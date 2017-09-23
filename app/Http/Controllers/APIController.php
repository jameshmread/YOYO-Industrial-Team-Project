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

        $firstPeriod = Carbon::createFromFormat('Ymdhis', $request->period1);
        $secondPeriod = Carbon::createFromFormat('Ymdhis', $request->period2);

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

    public function storesByTime(Request $request)
    {
        $name = $request->name;
        $name = str_replace("-", " ", $name);


//        return DB::table('transactions')
//            ->join('stores', 'transactions.store_id', '=', 'stores.id')
//            ->join('colours', 'stores.outlet_name', '=', 'colours.store')
//            ->select('stores.outlet_name', 'transactions.date', 'transactions.total_amount', 'colours.chart_colour')
//            ->where('stores.outlet_name', '=', $name)
//            ->where('colours.store', '=', $name)
//            ->where('date', '>=', $request->period1)
//            ->where('date', '<=', $request->period2)
//            ->get();

        if((DB::table('transactions')->join('stores', 'transactions.store_id', '=', 'stores.id')
                ->select('transactions.total_amount')
                ->where('stores.outlet_name', '=', $name)))
        {

            return DB::table('transactions')
                ->join('stores', 'transactions.store_id', '=', 'stores.id')
                ->join('colours', 'stores.outlet_name', '=', 'colours.store')
                ->select('stores.outlet_name', 'transactions.date', 'transactions.total_amount', 'colours.chart_colour')
                ->where('stores.outlet_name', '=', $name)
                ->where('colours.store', '=', $name)
                ->where('date', '>=', $request->period1)
                ->where('date', '<=', $request->period2)
                ->get();
        }
    }
}