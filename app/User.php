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
    public static function GetRights()
    {
        $rights = [];
        if('is_air_bar_staff' || 'is_admin')
        {
            array_push($rights,'Air Bar');
        }
        if('is_college_shop_staff' || 'is_admin')
            {
                array_push($rights,'College Shop');
            }
        if('is_dental_cafe_staff' || 'is_admin')
            {
                array_push($rights,'Dental Cafe');
            }
        if('is_djcad_cantina_staff' || 'is_admin')
            {
                array_push($rights,'DJCAD Cantina');
            }

        if('is_doj_catering_staff' || 'is_admin')
            {
                array_push($rights,'DOJ Catering');
            }
        if('is_dusa_marketplace_staff' || 'is_admin')
            {
                array_push($rights,'DUSA The Union: Marketplace');
            }
        if('is_dusa_union_online_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'DUSA The Union: Online');
            }
        if('is_dusa_ents_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Ents');
            }
        if('is_floor_five_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Floor Five');
            }
        if('is_food_on_four_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Food On Four');
            }
        if('is_level2_reception_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Level 2, Reception');
            }
        if('is_liar_bar_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Liar Bar');
            }
        if('is_library_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Library');
            }
        if('is_mono_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Mono');
            }
        if('is_ninewells_shop_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Ninewells Shop');
            }
        if('is_prem_shop_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Premier Shop');
                array_push($rights,'Premier Shop - Yoyo Accept');
            }
        if('is_remote_campus_shop_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Remote Campus Shop');
            }
        if('is_spare_staff' == true || 'is_admin' == true)
            {
                array_push($rights,'Spare');
            }

        return $rights;
    }

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
