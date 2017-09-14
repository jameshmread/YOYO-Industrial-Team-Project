<?php

namespace Tests\CSV;

use Tests\TestCase;
use App\Transaction;
use App\TransactionBuilder;

class TransactionBuilderTest extends TestCase
{
    private $tb;

    protected function setUp()
    {
        $this->tb = new TransactionBuilder;
    }

    /**
     * @dataProvider filePathsProvider
     */
    public function testCreateFromFile($filePath)
    {
        $csvFile = file($filePath);

        $transactionsArray = $this->tb->createFromFile($filePath);

        $expectedArraySize = sizeof($csvFile) -1;
        $this->assertEquals($expectedArraySize, sizeof($transactionsArray));

        foreach ($transactionsArray as $currentTransaction) {
            $this->assertEquals('App\Transaction', get_class($currentTransaction));
        }
    }

    /**
     * @depends testCreateFromFile
     */
    public function testTransactions()
    {
        $transactions = $this->tb->createFromFile(__DIR__.'/../../resources/csv/test.csv');
        $this->assertEquals(4.00, $transactions[16]->totalAmount);
        $this->assertEquals(-1.25, $transactions[7]->cash_spent);
        $this->assertEquals('239', $transactions[9]->storeId);
        $this->assertEquals('dusa-0017', $transactions[11]->customer_id);
        $this->assertEquals('24/08/2015 10:04:54', $transactions[2]->date);
        $this->assertEquals(0.00, $transactions[16]->discountAmount);
        $this->assertEquals('86ef272a30426fd61f3f440314b5d0cf', $transactions[1]->transaction_hash);
    }

    /**
     * @todo why isn't base_path() working?
     */
    public function filePathsProvider()
    {
        return [
            [__DIR__.'/../../resources/csv/test.csv'],
            //[__DIR__.'/../../resources/csv/Disbursals.csv'],
        ];
    }
}