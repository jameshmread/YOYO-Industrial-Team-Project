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
        $this->assertEquals(4.00, $transactions['7f0ca892ffc2387d716511ee55cdc134']->totalAmount);
        $this->assertEquals(-1.25, $transactions['84872a23509293c131a72d58d4a85f99']->cash_spent);
        $this->assertEquals('238', $transactions['bb464bce73e4d50a16a4cf6da3812b92']->storeId);
        $this->assertEquals('dusa-0046', $transactions['83c38ae916e5e4beafd7badf57721c9f']->customer_id);
        $this->assertEquals('24/08/2015 12:07:34', $transactions['51327b0ec6301e1ca646f9c41cef7638']->date);
        $this->assertEquals(0.00, $transactions['7f0ca892ffc2387d716511ee55cdc134']->discountAmount);
        $this->assertEquals('3f4d83428e0dd53c4d4b311ee787bccc', $transactions['3f4d83428e0dd53c4d4b311ee787bccc']->transaction_hash);
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