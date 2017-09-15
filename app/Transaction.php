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

    public $timestamps = false;

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
        $this->discount_amount = $discountAmount;
        $this->store_id = $storeId;
        $this->total_amount = $totalAmount;
        $this->transaction_type = $transactionType;
        $this->transaction_hash = hash('md5', "$cashSpent$customerId$date$discountAmount$storeId$totalAmount$transactionType");
    }

    public function customer()
    {
        return $this->hasOne('App\Customer');
    }

    public function store()
    {
        return $this->hasOne('App\Store');
    }
}
