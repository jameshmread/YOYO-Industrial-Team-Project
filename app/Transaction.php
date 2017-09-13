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

    public function __construct($date)
    {
        $this->customer_id = $date;
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
