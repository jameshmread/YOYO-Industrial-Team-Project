<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Carbon\Carbon;

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
            $month = null;
        }

        if ($request->day != null) {
            $day = $request->day;
        } else {
            $day = null;
        }

        return Carbon::createFromDate($year, $month, $day);
    }

    public function yearlyListing(Request $request)
    {
        //Format to follow for queries are as follows YYYY

        $date = $this->createListingDate($request);

        return dd($date);
    }

    public function monthlyListing(Request $request)
    {
        //Format to follow for queries are as follows YYYY/MM

        $date = $this->createListingDate($request);

        return dd($date);
    }

    public function dailyListing(Request $request)
    {
        //Format to follow for queries are as follows YYYY/MM/DD

        $date = $this->createListingDate($request);

        return dd($date);
    }

    public function periodToPeriod(Request $request)
    {
        dd($request->period1, $request->period2);
    }
}
