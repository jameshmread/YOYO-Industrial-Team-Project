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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function recentTransactions()
    {
        $data = array();
        //2 months ago
        $data[0] = Transaction::where('date', '>=',  new Carbon('first day of last month'))
            ->where('date', '<=', new Carbon('last day of last month'))
            ->sum('total_amount');

        //most recent month
        $data[1] = Transaction::where('date', '>=', new Carbon('first day of this month'))
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
        $multiStoresSalesDifference = [];
        $rights = Auth::user()->GetRights();
        $index = 0;
        foreach ($rights as $outlet) {
            #two months ago

            array_push($storeSalesPrevious, Transaction::where('date', '>=', new Carbon('first day of last month'))
                ->where('date', '<=', new Carbon('last day of last month'))
                ->where('outlet_name', '=', $outlet)
                ->sum('total_amount'));
            #last month
            array_push($storeSalesCurrent, Transaction::where('date', '>=',  new Carbon('first day of this month'))
                ->where('date', '<=', Carbon::now())
                ->where('outlet_name', '=', $outlet)
                ->sum('total_amount'));
            array_push($multiStoresSalesDifference, ($storeSalesCurrent[$index]-$storeSalesPrevious[$index]));
            $index++;
        }
        return [$storeSalesPrevious, $storeSalesCurrent, $rights, $multiStoresSalesDifference];
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
        $multiStoresSalesDifference = $this->totalSalesValue()[3];

        $customerVolume = $this->recentCustomerVolume();

        $thisMonthTransactions = $this->recentTransactions()[1];
        $lastMonthTransactions = $this->recentTransactions()[0];
        $difference = $thisMonthTransactions - $lastMonthTransactions;

        Carbon::setToStringFormat('d/m/y');
        $lastMonthStart = new Carbon('first day of last month');
        $lastMonthEnd = new Carbon('last day of last month');
        $startOfThisMonth = new Carbon('first day of this month');
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
            'startOfThisMonth',
            'currentDate',
            'multiStoresSalesDifference'
            ));
    }
}
