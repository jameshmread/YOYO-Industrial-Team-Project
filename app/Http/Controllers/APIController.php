<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Transaction;
use App\Store;
use Carbon\Carbon;

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

    public function spendingPath()
    {

        return Store::all()
            ->map(function ($item) {
                $store = null;
                $habit = null;

                if ($transactions = Transaction::where('store_id', '=', $item['outlet_reference'])
                        ->count() > 2) {
                    $user_totals = null;

                    User::all()
                        ->map(function ($item) use ($transactions) {

                        });
                }
            });
    }
}
