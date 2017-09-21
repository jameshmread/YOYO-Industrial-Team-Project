<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserRightsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_air_bar_staff')->default(0);
            $table->boolean('is_college_shop_staff')->default(0);
            $table->boolean('is_dental_cafe_staff')->default(0);
            $table->boolean('is_djcad_cantina_staff')->default(0);
            $table->boolean('is_doj_catering_staff')->default(0);
            $table->boolean('is_dusa_marketplace_staff')->default(0);
            $table->boolean('is_dusa_union_online_staff')->default(0);
            $table->boolean('is_dusa_ents_staff')->default(0);
            $table->boolean('is_floor_five_staff')->default(0);
            $table->boolean('is_food_on_four_staff')->default(0);
            $table->boolean('is_level2_reception_staff')->default(0);
            $table->boolean('is_liar_bar_staff')->default(0);
            $table->boolean('is_library_staff')->default(0);
            $table->boolean('is_mono_staff')->default(0);
            $table->boolean('is_ninewells_shop_staff')->default(0);
            $table->boolean('is_prem_shop_staff')->default(0);
            $table->boolean('is_remote_campus_shop_staff')->default(0);
            $table->boolean('is_spare_staff')->default(0);
        });
    }
}
