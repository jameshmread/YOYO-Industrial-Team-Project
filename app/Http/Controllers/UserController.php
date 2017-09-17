<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    
	public function index(){
		$users = User::all();
		return view('userlist', compact('users'));
	}

	public function show($id){
		$user = User::find($id);
		return view('edituser', compact('user'));
	}
	


    public function edit(Request $request){


$id = request('id');
$user = User::find($id);
$user->name = request('name');
$user->email = request('email');
$user->save();
return view('edituser', compact('user'));
}
}
