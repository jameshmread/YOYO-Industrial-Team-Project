<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'outlet_reference',
        'outlet_name',
    ];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
