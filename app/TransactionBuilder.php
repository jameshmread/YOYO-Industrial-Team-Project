<?php

namespace App;

use Illuminate\Support\Facades\DB;

class TransactionBuilder
{
    /**
     * @todo could probably use some refactoring - array_map makes the 
     * removeNullValuesFromArray method necessary.
     */
    public function createFromFile(string $filePath): array
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES);
        $transactions = array();
        foreach ($lines as $currentLine) {
            try {
                $transaction = $this->extractTransactionFromLine($currentLine);
                $transactions[$transaction->transaction_hash] = $transaction;
            } catch (\exception $e) { // @todo custom exception
                continue;
            }
        }
        return $transactions;
    }

    public function extractTransactionFromLine(string $line)
    {
        $array = str_getcsv($line);

        $date = $this->extractDate($array[0]);
        // I assumed the store id in the model and the outlet reference in the
        // model are the same - LM.
        $storeId = $array[2];

        $customerReference = $array[5];
        $customer = Customer::where('customer_reference', $customerReference)->first();
        if (null === $customer) {
            $customer = new Customer;
            $customer->customer_reference = $customerReference;
            $customer->save();
        }

        $transactionType = $array[6];
        $cashSpent = $this->extractPrice($array[7]);
        $discountAmount = $this->extractPrice($array[8]);
        $totalAmount = $this->extractPrice($array[9]);

        $transaction = new Transaction(
            $cashSpent,
            $customer->id,
            $date,
            $discountAmount,
            $storeId,
            $totalAmount,
            $transactionType
        );
        // echo '<pre>';
        // var_dump($cashSpent);
        // echo '</pre>';
        return $transaction;
    }

    public function extractDate(string $csvCell): string
    {
        $cellArray = explode(' ', str_replace(array('/', ':'), ' ', $csvCell));
        if (6 === sizeof($cellArray)) {
            $day = $cellArray[0];
            $month = $cellArray[1];
            $year = $cellArray[2];
            $hour = $cellArray[3];
            $minute = $cellArray[4];
            $second = $cellArray[5];
            return "$year-$month-$day $hour:$minute:$second";
        } else {
            throw new \ErrorException;
        }
    }

    public function extractPrice(string $csvCell): float
    {
        $prices = array();
        preg_match('/[0-9][.][0-9]{2}/', $csvCell, $prices);
        if (1 === sizeof($prices)) {
            $price = floatval($prices[0]);
            $isPositive = strpos($csvCell, '-') === false;
            if (!$isPositive) {
                $price *= -1;
            }
            return $price;
        } else {
            throw new \ErrorException;
        }
    }
}