<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\UsersDataTable;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display index page and process dataTable ajax request.
     *
     * @param \App\DataTables\UsersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(UsersDataTable $dataTable)
    {
        $trashed = User::onlyTrashed()->get();
        return $dataTable->render('user.index', compact('trashed'));
    }

    /**
     * Show create user page.
     *
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|integer|max:3',
            'phone' => 'numeric|phone|nullable',
        ]);

        $user = new User;

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');

        $user->save();

        return redirect()->route('user.show', $user->id)
            ->with('success', 'User created successfully');
    }

    /**
     * Show the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = "";

        return view('user.show', [ 'user' => $user ]);
    }

    /**
     * Edit the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = "";

        return view('user.edit', [ 'user' => $user ]);
    }

    /**
     * Update the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'sometimes|nullable|min:8|confirmed',
            'role' => 'required|integer|max:3',
            'phone' => 'numeric|phone|nullable',
        ]);
        
        $query = User::findOrFail($id);

        $query->name = $request->input('name');
        $query->email = $request->input('email');
        if ($request->input('password') != '') {
            $query->password = bcrypt($request->input('password'));
        }
        $query->role = $request->input('role');
        $query->phone = $request->input('phone');

        $query->save();

        return redirect()->route('user.show', $id)
            ->with('success', 'User updated successfully');
    }

    /**
     * Deletes a user.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            //If the user was already deleted then permanently delete it
            $user->forceDelete($user->id);
        } else {
            //Soft delete the user the first time
            $user->delete();
        }

        return redirect()->route('user.index')
            ->with('success','User deleted successfully');
    }
    
    /**
     * Restores a user.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();
        
        return redirect()->route('user.show', $user->id)
            ->with('success','User restored successfully');
    }
}
