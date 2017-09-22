<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\AdminUserRequest;

class AdminUserController extends Controller
{
    /**
     * array used to hole all possible roles a user may have
     * avoids generating on the fly
     *
     * @var array
     */
    protected static $user_rights = [
        'is_reportable' => 'Can receive reports',
        'is_reportable_only' => 'Can only receive reports',
        'is_air_bar_staff' => 'Air Bar',
        'is_college_shop_staff' => 'College Shop',
        'is_dental_cafe_staff' => 'Dental Cafe',
        'is_djcad_cantina_staff' => 'DJAD Cantina',
        'is_doj_catering_staff' => 'DOJ Catering',
        'is_dusa_marketplace_staff' => 'DUSA Marketplace',
        'is_dusa_union_online_staff' => 'DUSA Online',
        'is_dusa_ents_staff' => 'DUSA Entrance',
        'is_floor_five_staff' => 'Floor Five',
        'is_food_on_four_staff' => 'Food on Four',
        'is_level2_reception_staff' => 'Level 2 Reception',
        'is_liar_bar_staff' => 'Liar Bar',
        'is_library_staff' => 'Library',
        'is_mono_staff' => 'Mono',
        'is_ninewells_shop_staff' => 'Ninewells Shop',
        'is_prem_shop_staff' => 'Premier Shop',
        'is_remote_campus_shop_staff' => 'Remote Campus',
        'is_spare_staff' => 'Spare Shop',
    ];

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
        $user_rights = self::$user_rights;

        $page_details = [
            'title' => 'Create New User',
            'pagetitle' => 'Create New User',
            'route' => route('admin.users.store'),
            'methodtype' => 'POST',
            'button' => 'Create User'
        ];

        return view('admin.users_form', compact('user', 'page_details', 'user_rights'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request, User $user)
    {
        return $this->update($request, $user);
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
        $user_rights = self::$user_rights;

        $page_details = [
            'title' => 'Edit User',
            'pagetitle' => 'Editing' . ' ' . $user->name,
            'route' => route('admin.users.update', $user->id),
            'methodtype' => 'PUT',
            'button' => 'Update User'
        ];

        return view('admin.users_form', compact('user', 'page_details', 'user_rights'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminUserRequest $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserRequest $request, User $user)
    {
        // Iterates through the main user-rights properties and assigns them a default value of 0 or 1
        collect(self::$user_rights)->each(function ($value, $key) use ($user, $request) {
            $user->$key = in_array($key, $request->input('rights', [])) ? 1 : 0;
        });

        $tmpUser = User::find($user->id);

        $user->fill($request->all());

        $user->is_admin = $request->input('admin') ? 1 : 0;
        $user->report_frequency = $request->input('reportfrequency');

        if (!empty($request->input('password'))) {
            $pass = trim($request->input('password'));
            $user->password = bcrypt($pass);
        } else {
            $user->password = $tmpUser->password;
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
