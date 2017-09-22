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

    public function displayAngularPage () {
        return view('angular.angular');
    }
}
