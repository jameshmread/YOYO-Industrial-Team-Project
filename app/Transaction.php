<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public static function calculateHash(array $properties): string
    {
        return hash('md5', $properties['cash_spent'].
                           $properties['customer_id'].
                           $properties['date'].
                           $properties['discount_amount'].
                           $properties['store_id'].
                           $properties['outlet_name'].
                           $properties['total_amount'].
                           $properties['transaction_type']
        );
    }

    protected $fillable = [
        'customer_id',
        'store_id',
        'outlet_name',
        'date',
        'transaction_type',
        'cash_spent',
        'discount_amount',
        'total_amount',
        'transaction_hash',
    ];

    public $timestamps = false;

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
