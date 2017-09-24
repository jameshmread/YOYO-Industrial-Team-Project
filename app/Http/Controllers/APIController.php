<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Store;
use Illuminate\Http\Request;
use App\Transaction;
use App\Colours;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    const CORS_KEY = 'Access-Control-Allow-Origin';
    const CORS_VALUE = '*';

    public function recentTransactions()
    {
        $todayMinusMonth = Carbon::now()->subMonth();

        $recentTransactions = Transaction::where('date', '>=', $todayMinusMonth)
            ->get();
        return response()
            ->json($recentTransactions)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    private function createListingDate(Request $request)
    {
        if ($request->year != null) {
            $year = $request->year;
        }

        if ($request->month != null) {
            $month = $request->month;
        } else {
            $month = 1;
        }

        if ($request->day != null) {
            $day = $request->day;
        } else {
            $day = 1;
        }

        return Carbon::createFromDate($year, $month, $day);
    }

    private function retrieveListingByDate($date)
    {
        return Transaction::where('date', '>=', $date)
            ->get();
    }

    public function dmyListing(Request $request)
    {
        //Format will follow YYYY/MM/DD if available
        $transactionArray = $this->retrieveListingByDate($this->createListingDate($request));
        return response()->json($transactionArray)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    public function periodToPeriod(Request $request)
    {
        //Periods follow the format of YYYY-MM-DD HH:MM:SS

        $firstPeriod = Carbon::createFromFormat('YmdHis', $request->period1);
        $secondPeriod = Carbon::createFromFormat('YmdHis', $request->period2);

        $transactionArray = Transaction::where('date', '>=', $firstPeriod)
            ->where('date', '<=', $secondPeriod)
            ->get();
        return response()
            ->json($transactionArray)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    public function userVolumePerStore(Request $request)
    {
        $userVolumeArray = Store::all()->map(function ($item) use ($request) {
            return [
                'store' => $item['outlet_name'],
                'customers' => Transaction::where('outlet_name', '=', $item['outlet_name'])
                    ->where('date', '>=', $request->period1)
                    ->where('date', '<=', $request->period2)
                    ->count(),
                'color' => Colours::where('store', '=', $item['outlet_name'])->pluck('chart_colour')->first(),
            ];
        });

        return response()
            ->json($userVolumeArray)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }
    
        public function retainedUsersPerStore()
    {
 
        $customers = Transaction::all()->pluck('customer_id')->unique()->flatten();
 
        $userVolumeArray = Store::all()->map(function ($item) use ($customers) {
            return [
                'store' => $item['outlet_name'],
                'users_rentended' =>
                    $customers->map(function ($cust) use ($item) {
                        return [
                            'customer' => $cust,
                            'customer_retended' => Transaction::where('outlet_name', '=', $item['outlet_name'])
                                    ->where('customer_id', '=', $cust)->count() > 2
                        ];
                    })
            ];
        });
 
        $userVolumeArray = $userVolumeArray->map(function ($item) {
 
            $user = 0;
            foreach ($item['users_rentended'] as $value) {
                if ($value['customer_retended']) $user++;
            }
 
            return [
                'store' => $item['store'],
                'total_users_retained' => $user,
            ];
        });
 
        return response()
            ->json($userVolumeArray)
            ->header(self::CORS_KEY, self::CORS_VALUE);
 
    }

    public function totalSales()
    {
        $totalSales = Store::all()->map(function ($item) {
            return [
                'outlet_name' => $item['outlet_name'],
                'store_id' => $item['outlet_reference'],
                'total_sales' => Transaction::where('outlet_name', '=', $item['outlet_name'])
                    ->sum('total_amount')
            ];
        });
        return response()
            ->json($totalSales)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    public function averageSalesPerStore()
    {
        $returns = Store::all()->map(function ($item) {
            return
                [
                    $item['outlet_name'] => Transaction::where('outlet_name', '=', $item['outlet_name'])
                    ->orderby('date', 'asc')
                        ->select('total_amount', 'date')
                        ->get()
                ];

        });
        return response()
            ->json($returns->all())
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    public function storesByTime(Request $request)
    {
        $name = $request->name;
        $name = str_replace("-", " ", $name);

        if ((DB::table('transactions')->join('stores', 'transactions.outlet_name', '=', 'stores.outlet_name')
                ->select('transactions.total_amount')
                ->where('stores.outlet_name', '=', $name))) {

            return DB::table('transactions')
                ->join('stores', 'transactions.outlet_name', '=', 'stores.outlet_name')
                ->join('colours', 'stores.outlet_name', '=', 'colours.store')
                ->select('stores.outlet_name', 'transactions.date', 'transactions.total_amount', 'colours.chart_colour')
                ->where('stores.outlet_name', '=', $name)
                ->where('colours.store', '=', $name)
                ->where('date', '>=', $request->period1)
                ->where('date', '<=', $request->period2)
                ->get();
        }
    }


    public function totalStoreSalesByTime(Request $request)
    {

        $period1 = $request->period1;
        $period2 = $request->period2;

        $var = Store::all()->map(function ($item) use ($request){
            return [
                'outlet_name' => $item['outlet_name'],
                'sum_of_transactions' => Transaction::where('outlet_name', '=', $item['outlet_name'])->where('date', '>=', $request->period1)
                    ->where('date', '<=', $request->period2)->sum('total_amount'),
                'color' => Colours::where('store', '=', $item['outlet_name'])->pluck('chart_colour')->first(),
            ];

        });
        return response()
            ->json($var)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }



    public function uniqueUsersPerStore()
    {
        $userVolumeArray = Store::all()->map(function ($item) {
            return [
                'store' => $item['outlet_name'],
                'customers' => sizeof(Transaction::where('outlet_name', '=', $item['outlet_name'])
                    ->pluck('customer_id')->unique()->all()),
            ];
        });
        return response()->json($userVolumeArray)->header(self::CORS_KEY, self::CORS_VALUE);
    }
}

