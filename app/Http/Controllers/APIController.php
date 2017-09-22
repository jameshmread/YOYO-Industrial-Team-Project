<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Store;
use Illuminate\Http\Request;
use App\Transaction;
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

    public function userVolumePerStore()
    {
        // Will need a limit on returned transactions
        // Likely pass in day or set two method for week/month/year

        $userVolumeArray = Store::all()->map(function ($item) {
            return [
                'store' => $item['outlet_name'],
                'customers' => Transaction::where('store_id', '=', $item['outlet_reference'])
                    ->count(),
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
                            'customer_retended' => Transaction::where('store_id', '=', $item['outlet_reference'])
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
                'total_sales' => Transaction::where('store_id', '=', $item['outlet_reference'])
                    ->sum('total_amount')
            ];
        });
        return response()
            ->json($totalSales)
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    public function averageSalesPerStore()
    {
        $averages = Store::all()->map(function ($item) {
            return [
                'outlet_name' => $item['outlet_name'],
                'store_id' => $item['outlet_reference'],
                'average_transaction_value' => Transaction::where('store_id', '=', $item['outlet_reference'])
                        ->sum('total_amount') / Transaction::where('store_id', '=', $item['outlet_reference'])
                        ->count()
            ];
        });
        return response()
            ->json($averages->all())
            ->header(self::CORS_KEY, self::CORS_VALUE);
    }

    public function totalByStore()
    {
        return DB::select('select s.outlet_name as name, SUM(t.total_amount) as total, s.chart_colour as colour from transactions t, stores s where s.id = t.store_id group by t.store_id');
    }

    public function uniqueUsersPerStore()
    {
        $userVolumeArray = Store::all()->map(function ($item) {
            return [
                'store' => $item['outlet_name'],
                'customers' => sizeof(Transaction::where('store_id', '=', $item['outlet_reference'])
                    ->pluck('customer_id')->unique()->all()),
            ];
        });
        return response()->json($userVolumeArray)->header(self::CORS_KEY, self::CORS_VALUE);
    }
}
