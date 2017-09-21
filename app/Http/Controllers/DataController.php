<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function userVolumePerStore(Request $request, User $user)
    {
        // User will be used later to determine access
        return view('charts.uservolumeperstore_' . $request->type);
    }
}
