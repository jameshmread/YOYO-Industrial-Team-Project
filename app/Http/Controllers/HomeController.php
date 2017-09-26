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
        $data = array();
        //2 months ago
        $data[0] = Transaction::where('date', '>=',  new Carbon('first day of'.Carbon::now()->subMonths(2)))
            ->where('date', '<=', new Carbon('first day of'.Carbon::now()->subMonth()))
            ->sum('total_amount');

        //most recent month
        $data[1] = Transaction::where('date', '>=', new Carbon('first day of'.Carbon::now()))
            ->where('date', '<=', Carbon::now())
            ->sum('total_amount');

        return $data;
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
        $customerVolume = $this->recentCustomerVolume();

        $thisMonthTransactions = $this->recentTransactions()[1];
        $lastMonthTransactions = $this->recentTransactions()[0];
        $difference = $thisMonthTransactions - $lastMonthTransactions;

        return view('home', compact('thisMonthTransactions',
            'customerVolume',
            'lastMonthTransactions',
            'difference'));
    }
}
