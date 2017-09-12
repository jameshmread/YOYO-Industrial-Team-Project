<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'id',
        'outlet_reference',
        'outlet_name',
    ];

    public function transactions()
    {
        $this->hasMany('App\Transaction');
    }
}
