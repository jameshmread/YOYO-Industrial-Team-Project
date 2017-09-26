<?php

namespace Tests\CSV;

use Tests\DatabaseTestCase;
use App\Transaction;
use App\TransactionBuilder;
use App\TransactionFinder;

class TransactionBuilderTest extends DatabaseTestCase
{
    private $tb;

    protected function setUp()
    {
        $this->tb = new TransactionBuilder;
        parent::setUp();
    }

    /**
     * @dataProvider filePathsProvider
     */
    public function testCreateFromFile(string $file_path, int $transactions_n)
    {
        $transactions_array = $this->tb->createFromFile($file_path);

        $this->assertEquals($transactions_n, sizeof($transactions_array));

        foreach ($transactions_array as $current_transaction) {
            $this->assertEquals('App\Transaction', get_class($current_transaction));
        }
    }

    /**
     * @dataProvider filePathsProvider
     */
    public function testCopyTransactionsFromCsvToDb(
        string $file_path,
        int $transactions_n
    )
    {
        $previous_transactions_n = sizeof(Transaction::all());
        $this->tb->copyTransactionsFromCsvToDb($file_path);
        $current_transactions_n = sizeof(Transaction::all());
        $this->assertEquals($previous_transactions_n + $transactions_n, $current_transactions_n);
    }

    /**
     * @todo why isn't base_path() working?
     */
    public function filePathsProvider()
    {
        return [
            [__DIR__.'/../../resources/csv/test.csv', 16],
            [__DIR__.'/../../resources/csv/test2016.csv', 51],
            //[__DIR__.'/../../resources/csv/Disbursals.csv'],
        ];
    }

    private function getTransactionWithHash($collection, $hash): Transaction
    {
        $a = new TransactionFinder($hash);
        return $collection->first(array($a, 'isTransaction'));
    }
}