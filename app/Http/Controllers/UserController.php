<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit($id)
    {
        // TODO There is a better way to do this, but I forget late at night
        if (Auth::user()->id != $id) {
            return redirect('home');
        }

        $user = User::find($id);

        return view('edituser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // TODO There is a better way to do this, but I forget late at night
        if (Auth::user()->id != $user->id) {
            return redirect('home');
        }

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