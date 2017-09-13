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
        $price;
        echo '<pre>';
        echo '</pre>';
        return $array;
    }
}