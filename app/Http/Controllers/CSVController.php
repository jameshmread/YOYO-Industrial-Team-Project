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
            /**
             * @todo optimise: calling save on every model is probably
             * inefficient
             */
            foreach ($csv as $currentTransaction) {
                $currentTransaction->save();
            }
        } else {
            die;
        }
    }
}
