<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DataController extends Controller
{
    // TODO Add middleware __construct to check if access to this stores data?

    public function userVolumePerStore()
    {
        return view('charts.uservolumeperstore.uservolume');
    }

    public function totalSalesPerStore()
    {
        return view ('charts.totalsalesperstore.totalsales');
    }


    public function uniqueCustomersPerStore()
    {
        return view('charts.uniquecustomerssperstore.uniqueusers');
    }

    public function retainedCustomersPerStore()
    {
        return view('charts.retainedcustomersperstore.retainedusers');
    }

    public function salesOverDates()
    {
        return view('charts.salesovertime.salesdate');
    }

    public function averageSales()
    {
        return view('charts.averagesales.avgsales');
    }
}
