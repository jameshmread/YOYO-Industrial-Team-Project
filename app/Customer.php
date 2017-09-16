<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id',
        'customer_reference',
    ];
    public $timestamps = false;

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
