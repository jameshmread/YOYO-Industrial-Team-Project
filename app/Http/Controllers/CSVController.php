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
        // TODO AG Add $request validation

        $file = $request->file('inputFile');

        if ($file->isValid()) {
            $tb = new TransactionBuilder;
            $tb->copyTransactionsFromCsvToDb($file);
        } else {
            die;
        }

        return view('csv.csvconfirm');
    }
}
