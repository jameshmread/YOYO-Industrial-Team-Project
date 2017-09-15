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
        $this->assertEquals(0.50, $transactions['fed4ad8118913b381f331464f307cb18']->total_amount);
        $this->assertEquals(0.80, $transactions['54bd1daeef281a7177ddfed48e785fda']->cash_spent);
        $this->assertEquals('239', $transactions['73772429cd3bca77fd0c3b6b8c2eff52']->store_id);
        $this->assertEquals('9', $transactions['91d2379e3e69c6a4e6d500984ba43403']->customer_id);
        $this->assertEquals('2015-08-25 12:49:44', $transactions['db8f1d15adebfdb329094f7e3ef635d4']->date);
        $this->assertEquals(0.00, $transactions['9d7bcf7dc6faec68447e5860f3115e50']->discount_amount);
        $this->assertEquals('07c10a4486e18e9a9c53bbfbdb9f6256', $transactions['07c10a4486e18e9a9c53bbfbdb9f6256']->transaction_hash);
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