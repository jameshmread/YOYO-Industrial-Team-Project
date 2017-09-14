<?php

namespace App;

class TransactionBuilder
{
    /**
     * @todo could probably use some refactoring - array_map makes the 
     * removeNullValuesFromArray method necessary.
     */
    public function createFromFile(string $filePath): array
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES);
        $csv = array_map(array($this, 'convertLineIntoTransaction'), $lines);
        $this->removeNullValuesFromArray($csv);
        return $csv;
    }

    public function convertLineIntoTransaction(string $line)
    {
        $transaction = null;
        try {
            $array = str_getcsv($line);

            $date = $this->extractDate($array[0]);
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
        } catch (\ErrorException $e) {
            return null;
        }
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
            return "$day/$month/$year $hour:$minute:$second";
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

    public function removeNullValuesFromArray(array &$array)
    {
        $sizeOfArray = sizeof($array);
        for ($i = $sizeOfArray - 1; $i >= 0; $i--) {
            if (null === $array[$i]) {
                unset($array[$i]);
            }
        }
    }
}