<?php

namespace App;

/**
 * @see TransactionBuilderTest#getTransactionWithHash
 */
class TransactionFinder
{
    private $hash;

    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public function isTransaction($transaction)
    {
        return $transaction->transaction_hash === $this->hash;
    }
}