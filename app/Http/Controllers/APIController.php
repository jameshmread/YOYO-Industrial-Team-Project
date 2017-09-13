<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Carbon\Carbon;

class APIController extends Controller
{
    public function recentTransactions() {

        $todayMinusMonth = Carbon::now()->subMonth();

        $recentTransactions = Transaction::where('date', '>=', $todayMinusMonth)
            ->get();

        return $recentTransactions;
    }

    public function monthlyListing(Request $request) {
        return $request->month;
    }

    public function periodToPeriod(Request $request) {
        dd($request->period1, $request->period2);
    }
}
