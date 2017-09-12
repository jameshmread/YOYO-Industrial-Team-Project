<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id',
        'customer_reference',
    ];

    public function transactions()
    {
        $this->hasMany('App\Transaction');
    }
}
