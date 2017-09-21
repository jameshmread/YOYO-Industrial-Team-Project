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

    public $timestamps = false;

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
