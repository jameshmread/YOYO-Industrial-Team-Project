<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransactionBuilder;
use App\Transaction;

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
            $tb = new TransactionBuilder;
            $csv = $tb->createFromFile($file);
            dd($csv);
        } else {
            die;
        }
    }
}
