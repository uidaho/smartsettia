<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\UsersDataTable;
use App\User;
use Illuminate\Support\Facades\Auth;

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
        $this->authorize('index', User::class);
        
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
        $this->authorize('create', User::class);
        
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
        $this->authorize('store', User::class);
        
        request()->validate([
            'name' => 'required|min:2|max:190|full_name',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|integer|max:3',
            'phone' => 'numeric|phone|nullable',
        ]);
    
        $user = User::create([ 'name' => $request->name,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'role' => $request->input('role'),]);

        return redirect()->route('user.show', $user->id)
            ->with('success', 'User created successfully');
    }

    /**
     * Show the given user.
     *
     * @param  User  $user
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $this->authorize('show', $user);
        
        $user->password = "";
        
        return view('user.show', [ 'user' => $user ]);
    }

    /**
     * Edit the given user.
     *
     * @param  User  $user
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);
        
        $user->password = "";

        return view('user.edit', [ 'user' => $user ]);
    }

    /**
     * Update the given user.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        request()->validate([
            'name' => 'sometimes|nullable|min:2|max:190|full_name',
            'email' => 'sometimes|nullable|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|nullable|min:8|confirmed',
            'role' => 'sometimes|nullable|integer|max:3',
            'phone' => 'numeric|phone|nullable',
            'preferred_device_id' => 'nullable|integer|digits_between:1,10|exists:devices,id',
        ]);

        if ($request->input('name') != null)
        {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            if ($request->input('password') != '')
                $user->password = bcrypt($request->input('password'));
            if (Auth::user()->can('updateRole', $user))
                $user->role = $request->input('role');
        }
        else
            $user->preferred_device_id = $request->input('preferred_device_id');

        $user->save();
    
        if (\Request::ajax())
            return response()->json([ 'success' => 'Preferred device updated successfully' ]);
        else
            return redirect()->route('user.show', $user->id)
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
        $this->authorize('destroy', $user);

        if ($user->trashed()) {
            //If the user was already deleted then permanently delete it
            $user->forceDelete($user->id);
        } else {
            //Soft delete the user the first time
            $user->delete();
        }

        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully');
    }
    
    /**
     * Restores a user.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $this->authorize('restore', User::class);
        
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();
        
        return redirect()->route('user.show', $user->id)
            ->with('success', 'User restored successfully');
    }
}
