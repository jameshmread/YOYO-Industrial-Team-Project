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

    public function displayAngularPage()
    {
        return view('angular.angular');
    }

    public function uniqueUsersPerStore()
    {
        return view('angular.unique');
    }

    public function retainedUsersPerStore()
    {
        return view('angular.retained');
    }

    public function SalesOverDates()
    {
        return view('charts.salesovertime.salesdate');
    }

    public function AverageSales()
    {
        return view('charts.avgsales');
    }
}
