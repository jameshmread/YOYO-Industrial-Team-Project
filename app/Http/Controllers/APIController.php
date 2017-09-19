<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Store;
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

    public function userVolumePerStore()
    {
        // Will need a limit on returned transactions
        // Likely pass in day or set two method for week/month/year

        return Store::all()->map(function ($item) {
            return [
                'store' => $item['outlet_name'],
                'customers' => Transaction::where('store_id', '=', $item['outlet_reference'])
                    ->count(),
            ];
        });
    }
}
