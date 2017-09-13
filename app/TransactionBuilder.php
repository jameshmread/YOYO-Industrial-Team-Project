<?php

namespace App;

use App\Types\Date;

class TransactionBuilder
{
    public function createFromFile(string $filePath): array
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES);
        unset($lines[0]);
        $csv = array_map(array($this, 'convertLineIntoTransaction'), $lines);
        return $csv;
    }

    public function convertLineIntoTransaction(string $line): array
    {
        $array = str_getcsv($line);

        $date = new Date($array[0]);
        // I assumed the store id in the model and the outlet reference in the
        // model are the same - LM.
        $storeId = $array[2];
        $customerId = $array[5];
        $transactionType = $array[6];
        $cashSpent = $this->extractPrice($array[7]);
        $discountAmount = $this->extractPrice($array[8]);
        $totalAmount = $this->extractPrice($array[9]);
        $transaction = new Transaction(
            $cashSpent,
            $customerId,
            $date,
            $discountAmount,
            $storeId,
            $totalAmount,
            $transactionType
        );
        // echo '<pre>';
        // var_dump($cashSpent);
        // echo '</pre>';
        return $array;
    }

    public function extractPrice(string $string): float
    {
        $prices = array();
        preg_match('/[0-9][.][0-9]{2}/', $string, $prices);
        $price = floatval($prices[0]);
        $isPositive = strpos($string, '-') === false;
        if (!$isPositive) {
            $price *= -1;
        }
        return $price;
    }
}