<?php

namespace App\Http\Controllers;
use App\Customer;
use App\User;
use Illuminate\Support\Facades\Auth;
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

    public function totalSalesValue()
    {
        $storeSalesPrevious = [];
        $storeSalesCurrent = [];
        $rights = Auth::User()->GetRights();
//        return $rights;
        foreach ($rights as $outlet) {
            #two months ago
            array_push($storeSalesPrevious, Transaction::where('date', '>=',  new Carbon('first day of'.Carbon::now()->subMonths(2)))
                ->where('date', '<=', new Carbon('first day of'.Carbon::now()->subMonth()))
                ->where('outlet_name', '=', $outlet)
                ->sum('total_amount'));
            #last month
            array_push($storeSalesCurrent, Transaction::where('date', '>=',  new Carbon('first day of'.Carbon::now()))
                ->where('date', '<=', Carbon::now())
                ->where('outlet_name', '=', $outlet)
                ->sum('total_amount'));
        }
        return [$storeSalesPrevious, $storeSalesCurrent, $rights];
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
        $managersStoreSalesPrevious = $this->totalSalesValue()[0];
        $managersStoreSalesCurrent = $this->totalSalesValue()[1];
        $rights = $this->totalSalesValue()[2];
        //still need to do difference for all sales


        $customerVolume = $this->recentCustomerVolume();

        $thisMonthTransactions = $this->recentTransactions()[1];
        $lastMonthTransactions = $this->recentTransactions()[0];
        $difference = $thisMonthTransactions - $lastMonthTransactions;
        Carbon::setToStringFormat('d/m/y');
        $lastMonthStart = new Carbon('first day of'.Carbon::now()->subMonths(2)->toDateString());
        $lastMonthEnd = new Carbon('first day of'.Carbon::now()->subMonth()->toDateString());
//        $lastMonthStart->toFormattedDateString();
        $currentDate = Carbon::now();
        return view('home', compact('thisMonthTransactions',
            'customerVolume',
            'lastMonthTransactions',
            'difference',
            'managersStoreSalesPrevious',
            'managersStoreSalesCurrent',
            'rights',
            'lastMonthStart',
            'lastMonthEnd',
            'currentDate'
            ));
    }
}
