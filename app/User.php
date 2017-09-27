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


    /**
     * @return array
     * Returns an array of stores based on user permissions.
     * As a result, this can be passed right into a component that is expecting that data.
     * -- Example --
     *   <test :store="{{json_encode(Auth:user()->GetRights())}}></test>
     */
    public function GetRights()
    {
        $rights = [];
        if($this->is_air_bar_staff || $this->is_admin)
        {
            array_push($rights,'Air Bar');
        }
        if($this->is_college_shop_staff || $this->is_admin)
        {
            array_push($rights,'College Shop');
        }
        if($this->is_dental_cafe_staff || $this->is_admin)
        {
            array_push($rights,'Dental Cafe');
        }
        if($this->is_djcad_cantina_staff || $this->is_admin)
        {
            array_push($rights,'DJCAD Cantina');
        }

        if($this->is_doj_catering_staff || $this->is_admin)
        {
            array_push($rights,'DOJ Catering');
        }
        if($this->is_dusa_marketplace_staff || $this->is_admin)
        {
            array_push($rights,'DUSA The Union: Marketplace');
        }
        if($this->is_dusa_union_online_staff || $this->is_admin)
        {
            array_push($rights,'DUSA The Union: Online');
        }
        if($this->is_dusa_ents_staff || $this->is_admin)
        {
            array_push($rights,'Ents');
        }
        if($this->is_floor_five_staff || $this->is_admin)
        {
            array_push($rights,'Floor Five');
        }
        if($this->is_food_on_four_staff || $this->is_admin)
        {
            array_push($rights,'Food On Four');
        }
        if($this->is_level2_reception_staff || $this->is_admin)
        {
            array_push($rights,'Level 2, Reception');
        }
        if($this->is_liar_bar_staff || $this->is_admin)
        {
            array_push($rights,'Liar Bar');
        }
        if($this->is_library_staff || $this->is_admin)
        {
            array_push($rights,'Library');
        }
        if($this->is_mono_staff || $this->is_admin)
        {
            array_push($rights,'Mono');
        }
        if($this->is_ninewells_shop_staff || $this->is_admin)
        {
            array_push($rights,'Ninewells Shop');
        }
        if($this->is_prem_shop_staff || $this->is_admin)
        {
            array_push($rights,'Premier Shop');
            array_push($rights,'Premier Shop - Yoyo Accept');
        }
        if($this->is_remote_campus_shop_staff || $this->is_admin)
        {
            array_push($rights,'Remote Campus Shop');
        }
        if($this->is_spare_staff || $this->is_admin)
        {
            array_push($rights,'Spare');
        }

        return $rights;
    }


    /**
     * @return bool
     * returns true or false (1 or 0) depending on if the user is admin or not.
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @return bool
     * returns true or false (1 or 0) depending on if the user has reportable permissions or not.
     */
    public function isReportable()
    {
        return $this->is_reportable;
    }

    /**
     * @return bool
     * returns true or false (1 or 0) depending on if the user only has reportable permissions or not.
     */
    public function isReportableOnly()
    {
        return $this->is_reportable_only;
    }
}
