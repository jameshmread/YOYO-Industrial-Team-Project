<?php

namespace App;

use App\Exceptions\InvalidLineException;
use InvalidArgumentException;

/**
 * @todo PHPDoc
 * @todo snake_case
 * @todo use convert store name to slug
 */
class TransactionBuilder
{
    public function createFromFile(string $filePath): array
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES);
        $transactions = array();
        foreach ($lines as $currentLine) {
            try {
                $transaction = $this->extractTransactionFromLine($currentLine);
                // Adds the extracted transaction to the array, using its hash
                // as its key.
                $transactions[$transaction->transaction_hash] = $transaction;
            } catch (InvalidLineException $e) {
                continue;
            }
        }
        return $transactions;
    }

    public function copyTransactionsFromCsvToDb(string $filePath)
    {
        $file_handle = fopen($filePath, 'r');
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            try {
                $transaction = $this->extractTransactionFromLine($line);
                if (!$transaction->wasRecentlyCreated) {
                    $transaction->save();
                }
            } catch (InvalidLineException $e) {
                continue;
            }
        }
        fclose($file_handle);
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
        $storeId = $array[2];

        $store_name = $array[4];

        if (null === Store::where('outlet_reference', $storeId)->first()) {
            Store::create([
                'outlet_reference' => $storeId,
                'outlet_name' => $store_name,
            ]);
        }

        $customerReference = $array[5];
        $customer = Customer::where('customer_reference', $customerReference)->first();
        if (null === $customer) {
            $customer = new Customer();
            $customer->customer_reference = $customerReference;
            $customer->save();
        }
        $transactionType = $array[6];
        try {
            $cashSpent = $this->extractPrice($array[7]);
            $discountAmount = $this->extractPrice($array[8]);
            $totalAmount = $this->extractPrice($array[9]);
        } catch (InvalidArgumentException $e) {
            throw new InvalidLineException();
        }

        $transaction = $this->firstOrCreateTransaction([
            'customer_id' => $customer->id,
            'store_id' => $storeId,
            'outlet_name' => $store_name,
            'date' => $date,
            'transaction_type' => $transactionType,
            'cash_spent' => $cashSpent,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
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
    public function extractDate(string $csvCell, bool $strict = true): string
    {
        $cellArray = explode(' ', str_replace(array('/', ':'), ' ', $csvCell));
        if ($strict && 6 !== sizeof($cellArray)) {
            throw new InvalidArgumentException();
        } else {
            $day = isset($cellArray[0]) ? $cellArray[0] : date('d');
            $month = isset($cellArray[1]) ? $cellArray[1] : date('m');
            $year = isset($cellArray[2]) ? $cellArray[2] : date('Y');
            $hour = isset($cellArray[3]) ? $cellArray[3] : date('H');
            $minute = isset($cellArray[4]) ? $cellArray[4] : date('i');
            $second = isset($cellArray[5]) ? $cellArray[5] : date('s');
            return "$year-$month-$day $hour:$minute:$second";
        }
    }

    public function extractPrice(string $csvCell): float
    {
        $prices = array();
        preg_match('/\d(\.(\d)?(\d)?)?/', $csvCell, $prices);
        if (sizeof($prices) > 0) {
            $price = floatval($prices[0]);
            $isPositive = strpos($csvCell, '-') === false;
            if (!$isPositive) {
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