<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function recentTransactions() {
        return 'hello';
    }

    public function monthlyListing(Request $request) {
        return $request->month;
    }

    public function periodToPeriod(Request $request) {
        dd($request->period1, $request->period2);
    }
}
