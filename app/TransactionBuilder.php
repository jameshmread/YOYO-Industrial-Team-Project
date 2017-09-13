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
        $price = $this->extractPrice($array[7]);
        echo '<pre>';
        var_dump($price);
        echo '</pre>';
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