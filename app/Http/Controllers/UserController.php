<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function edit($id)
    {
        $user = User::find($id);

        return view('edituser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'alpha',
            'email' => 'email',
        ]);

        if (!empty($request->input('name'))) {
            $user->name = $request->input('name');
        }

        if (!empty($request->input('email'))) {
            $user->email = $request->input('email');
        }

        $user->save();

        return redirect('home');
    }
}
