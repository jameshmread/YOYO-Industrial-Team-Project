<?php

namespace App\Http\Controllers;
use App\Customer;
use App\User;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
class HomeController extends Controller
{

    public function recentTransactions()
    {
        $todayMinusMonth = Carbon::now()->subMonth();

        return Transaction::where('date', '>=', $todayMinusMonth)
            ->sum('total_amount');

    }

    public function recentCustomerVolume()
    {
        return Customer::all()->count();
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recentTransactions = $this->recentTransactions();
        $recentCustomerVolume = $this->recentCustomerVolume();

        return view('home', compact('recentTransactions', 'recentCustomerVolume'));
    }
}
