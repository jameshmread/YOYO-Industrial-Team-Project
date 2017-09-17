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

<<<<<<< HEAD
    public function __construct()
    {}

=======
>>>>>>> master
    public function customer()
    {
        return $this->hasOne('App\Customer');
    }

    public function store()
    {
        return $this->hasOne('App\Store');
    }

    public function updateTransactionHash()
    {
        $this->transaction_hash = hash('md5', ''.$this->cash_spent.$this->customer_id.$this->date.$this->discount_amount.$this->store_id.$this->total_amount.$this->transaction_type);        
    }
}
