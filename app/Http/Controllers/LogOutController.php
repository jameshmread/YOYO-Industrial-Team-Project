<?php

namespace App\Http\Controllers\Auth;


class LogOutController extends Controller{

    public function logOut(){

        Auth::logout();
        return redirect('/');


    }




}