<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colours extends Model
{
    protected $fillable = [
        'id',
        'chart_colour',
        'store'
    ];

    public $timestamps = false;

    public function stores()
    {
        return $this->hasOne('App\Store');
    }
}
