<?php

namespace App;

use App\Exceptions\InvalidLineException;
use InvalidArgumentException;
use Maatwebsite\Excel\Facades\Excel;
use App\UserTransactionsValueBinder;

/**
 * @todo PHPDoc
 * @todo use convert store name to slug
 * @todo process excel dates correctly
 */
class TransactionBuilder
{
    /**
    * @deprecated It cannot read Excel files as it is not using Laravel Excel's
    * API.
    */
    public function createFromFile(string $file_path): array
    {
        $lines = file($file_path, FILE_IGNORE_NEW_LINES);
        $transactions = array();
        foreach ($lines as $current_line) {
            try {
                $transaction = $this->extractTransactionFromLine($current_line);
                // Adds the extracted transaction to the array, using its hash
                // as its key.
                $transactions[$transaction->transaction_hash] = $transaction;
            } catch (InvalidLineException $e) {
                continue;
            }
        }
        return $transactions;
    }

    public function copyTransactionsFromCsvToDb(string $file_path)
    {
        $binder = new UserTransactionsValueBinder();
        Excel::filter('chunk')->load($file_path)->chunk(250, function($sheets_collection)
        {
            foreach ($sheets_collection as $current_sheet) {
                foreach ($current_sheet as $current_row) {
                    try {
                        $line = $current_row[0].','.
                                $current_row[1].','.
                                $current_row[2].','.
                                $current_row[3].','.
                                $current_row[4].','.
                                $current_row[5].','.
                                $current_row[6].','.
                                $current_row[7].','.
                                $current_row[8].','.
                                $current_row[9];
                        $transaction = $this->extractTransactionFromLine($line);
                        if (!$transaction->wasRecentlyCreated) {
                            $transaction->save();
                        }
                    } catch (InvalidLineException $e) {
                        continue;
                    }
                }
            }
        }, 'UTF-8');
    }

    public function extractTransactionFromLine(string $line): Transaction
    {
        $array = str_getcsv($line);
        if (!is_array($array) || sizeof($array) < 10) {
            throw new InvalidLineException;
        }
        $date = $this->extractDate($array[0], false);
        // I assumed the store id in the model and the outlet reference in the
        // model are the same - LM.
        $store_id = $array[2];

        $store_name = $array[4];

        if (null === Store::where('outlet_reference', $store_id)->first()) {
            Store::create([
                'outlet_reference' => $store_id,
                'outlet_name' => $store_name,
            ]);
        }

        $customer_reference = $array[5];
        $customer = Customer::where('customer_reference', $customer_reference)->first();
        if (null === $customer) {
            $customer = new Customer();
            $customer->customer_reference = $customer_reference;
            $customer->save();
        }
        $transaction_type = $array[6];
        try {
            $cash_spent = $this->extractPrice($array[7]);
            $discount_amount = $this->extractPrice($array[8]);
            $total_amount = $this->extractPrice($array[9]);
        } catch (InvalidArgumentException $e) {
            throw new InvalidLineException();
        }

        $transaction = $this->firstOrCreateTransaction([
            'customer_id' => $customer->id,
            'store_id' => $store_id,
            'outlet_name' => $store_name,
            'date' => $date,
            'transaction_type' => $transaction_type,
            'cash_spent' => $cash_spent,
            'discount_amount' => $discount_amount,
            'total_amount' => $total_amount,
        ]);
        return $transaction;
    }

    /**
     * Extract a date from a string with the following format:
     * DD/MM/YYYY HH:MM:SS.
     *
     * @param bool strict Do not throw an exception for any time component that
     * could not be extracted from the string, and complete the missing
     * component with the corresponding component from the current time.
     */
    public function extractDate(string $csv_cell, bool $strict = true): string
    {
        $cell_array = explode(' ', str_replace(array('/', ':'), ' ', $csv_cell));
        if ($strict && 6 !== sizeof($cell_array)) {
            throw new InvalidArgumentException();
        } else {
            $day = isset($cell_array[0]) ? $cell_array[0] : date('d');
            $month = isset($cell_array[1]) ? $cell_array[1] : date('m');
            $year = isset($cell_array[2]) ? $cell_array[2] : date('Y');
            $hour = isset($cell_array[3]) ? $cell_array[3] : date('H');
            $minute = isset($cell_array[4]) ? $cell_array[4] : date('i');
            $second = isset($cell_array[5]) ? $cell_array[5] : date('s');
            return "$year-$month-$day $hour:$minute:$second";
        }
    }

    public function extractPrice(string $csv_cell): float
    {
        $prices = array();
        preg_match('/\d(\.(\d)?(\d)?)?/', $csv_cell, $prices);
        if (sizeof($prices) > 0) {
            $price = floatval($prices[0]);
            $is_positive = strpos($csv_cell, '-') === false;
            if (!$is_positive) {
                $price *= -1;
            }
            return $price;
        } else {
            throw new InvalidArgumentException();
        }
    }

    
    public function firstOrCreateTransaction(array $properties): Transaction
    {
        $hash = Transaction::calculateHash($properties);
        $properties['transaction_hash'] = $hash;
        return Transaction::firstOrCreate($properties);
    }
}