<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'store_id',
        'date',
        'transaction_type',
        'cash_spent',
        'discount_amount',
        'total_amount',
        'transaction_hash',
    ];

    /**
     * @todo add transaction_hash parameter
     */
    public function __construct(
        $cashSpent,
        $customerId,
        $date,
        $discountAmount,
        $storeId,
        $totalAmount,
        $transactionType
    )
    {
        $this->cash_spent = $cashSpent;
        $this->customer_id = $customerId;
        $this->date = $date;
        $this->discountAmount = $discountAmount;
        $this->storeId = $storeId;
        $this->totalAmount = $totalAmount;
        $this->transactionType = $transactionType;
    }

    public function customer()
    {
        $this->hasOne('App\Customer');
    }

    public function store()
    {
        $this->hasOne('App\Store');
    }
}
