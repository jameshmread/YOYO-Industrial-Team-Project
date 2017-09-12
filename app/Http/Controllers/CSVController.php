<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CSVController extends Controller
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

    public function index()
    {
        return view('csv.csvupload');
    }

    public function upload(Request $request)
    {
        $file = $request->file('inputFile');

        if($file->isValid()) {
            $csv = array_map('str_getcsv', file($file));

            dd($csv);
        } else {
            die;
        }
    }
}
