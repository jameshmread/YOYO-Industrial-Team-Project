<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function recentTransactions()
    {
        $todayMinusMonth = Carbon::now()->subMonth();

        $recentTransactions = Transaction::where('date', '>=', $todayMinusMonth)
            ->get();

        return $recentTransactions;
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
        return $this->retrieveListingByDate($this->createListingDate($request));
    }

    public function periodToPeriod(Request $request)
    {
        //Periods follow the format of YYYY-MM-DD HH:MM:SS

        $firstPeriod = Carbon::createFromFormat('Ymdhis', $request->period1);
        $secondPeriod = Carbon::createFromFormat('Ymdhis', $request->period2);

        return Transaction::where('date', '>=', $firstPeriod)
            ->where('date', '<=', $secondPeriod)
            ->get();
    }

    public function totalByStore(){

        return DB::select('select s.outlet_name as name, SUM(t.total_amount) as total from transactions t, stores s where s.id = t.store_id group by t.store_id');

    }

    public function storesByTime(Request $request){
//
//        $name = $request ->name;
//        $firstPeriod = Carbon::createFromFormat('YYYY-MM-DD', $request->period1);
//        $secondPeriod = Carbon::createFromFormat('YYYY-MM-DD', $request->period2);
//
//        return DB::table('transactions')
//            ->join('stores', 'transactions.store_id', '=', 'stores.id')
//            ->select('stores.outlet_name', 'transactions.date', 'transactions.total_amount')
//            ->where('stores.outlet_name', '=', $name)
//            ->where('date', '>=', $firstPeriod)
//            ->where('date', '<=', $secondPeriod)
//            ->get();

//        return DB::select('SELECT s.outlet_name as name, t.date as date,
//		                  t.total_amount as total
//                          FROM transactions t, stores s
//                          WHERE t.store_id = s.id
//                          AND s.outlet_name = \'Liar Bar\'
//                            AND (t.date BETWEEN \'2017-09-01\' AND \'2017-09-30\'');

    }
}