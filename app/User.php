<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_air_bar_staff',
        'is_college_shop_staff',
        'is_dental_cafe_staff',
        'is_djcad_cantina_staff',
        'is_doj_catering_staff',
        'is_dusa_marketplace_staff',
        'is_dusa_union_online_staff',
        'is_dusa_ents_staff',
        'is_floor_five_staff',
        'is_food_on_four_staff',
        'is_level2_reception_staff',
        'is_liar_bar_staff',
        'is_library_staff',
        'is_mono_staff',
        'is_ninewells_shop_staff',
        'is_prem_shop_staff',
        'is_remote_campus_shop_staff',
        'is_spare_staff',
        'is_reportable',
        'is_reportable_only',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
