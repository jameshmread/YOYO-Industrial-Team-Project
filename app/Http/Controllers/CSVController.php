<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CSVController extends Controller
{
    public function index()
    {
        return view('csv.csvupload');
    }

    public function upload(Request $request)
    {
        $file = $request->file('inputFile');

        if ($file->isValid()) {
            $lines = file($file, FILE_IGNORE_NEW_LINES);
            $csv = array_map('str_getcsv', $lines);
            
            dd($csv);
        } else {
            die;
        }
    }
}
