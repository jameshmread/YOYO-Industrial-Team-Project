<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();

        $page_details = [
            'title' => 'Create New User',
            'pagetitle' => 'Create New User',
            'route' => route('admin.users.store'),
            'methodtype' => 'POST',
            'button' => 'Create User'
        ];

        return view('admin.users_form', compact('user', 'page_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        return $this->update($request, $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $page_details = [
            'title' => 'Edit User',
            'pagetitle' => 'Editing' . ' ' . $user->name,
            'route' => route('admin.users.update', $user->id),
            'methodtype' => 'PUT',
            'button' => 'Update User'
        ];

        return view('admin.users_form', compact('user', 'page_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->fill($request->all());

        // Password check
        $this->validate($request, [
            'password' => 'bail|required|min:6|confirmed',
            'name' => 'required|alpha',
            'email' => 'required|email'
        ]);
        if (!empty($request->input('password'))) {
            $pass = trim($request->input('password'));
            $user->password = password_hash($pass, PASSWORD_DEFAULT);
        }

        // Save to database
        $request->session()->flash('success',
            "User {$user->name} " . ($user->exists ? 'edited' : 'created') . " successfully.");

        $user->save();

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Update later with Sweet alert 2

        User::destroy($id);

        $request->session()->flash('success',
            "User deleted successfully.");

        return redirect(route('admin.users.index'));
    }
}
