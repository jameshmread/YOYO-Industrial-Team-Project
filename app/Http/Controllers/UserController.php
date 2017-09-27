<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected static $user_rights = [
        'Air Bar',
        'College Shop',
        'Dental Cafe',
        'DJAD Cantina',
        'DOJ Catering',
        'DUSA Marketplace',
        'DUSA Online',
        'DUSA Entrance',
        'Floor Five',
        'Food on Four',
        'Level 2 Reception',
        'Liar Bar',
        'Library',
        'Mono',
        'Ninewells Shop',
        'Premier Shop',
        'Remote Campus',
        'Spare',
    ];

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
        if (Auth::user()->id != $user->id) {
            return redirect('home');
        }

        $request->validate([
            'name' => 'alpha',
            'email' => 'email',
            'password' => 'confirmed'
        ]);

        if (!empty($request->input('name'))) {
            $user->name = $request->input('name');
        }

        if (!empty($request->input('email'))) {
            $user->email = $request->input('email');
        }

        if (!empty($request->input('password'))) {
            $pass = trim($request->input('password'));
            $user->password = bcrypt($pass);
        }

        $user->save();

        return redirect('home');
    }

    public function reports()
    {
        $user_rights = self::$user_rights;

        return view('user_reports', compact('user_rights'));
    }
}
