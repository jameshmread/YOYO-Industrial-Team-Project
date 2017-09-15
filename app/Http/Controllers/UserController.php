<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    
	public function index(){
		$users = User::all();
		return view('index', compact('users'));
	}

	public function show($id){
		$user = User::find($id);
		return view('show', compact('user'));
	}
	


    public function edit(Request $request){


$id = request('id');
$user = User::find($id);
$user->name = request('name');
$user->email = request('email');
$user->save();
return view('show', compact('user'));
}
}
