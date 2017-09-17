<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function barchart()
    {
        return view('dataexamples.barchart');
    }

    public function linechart()
    {
        return view('dataexamples.linechart');
    }
}
