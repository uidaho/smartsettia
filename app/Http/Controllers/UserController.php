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
        // TODO: Setup logging
        // $this->middleware('log')->only('index');
    }

    /**
     * Display index page and process dataTable ajax request.
     *
     * @param \App\DataTables\UsersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer|max:3',
            'phone' => 'numeric|phone|nullable',
        ]);

        if ($validator->fails()) {
            return redirect('user/create')->withErrors($validator)->withInput();
        }

        $user = new User;

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');

        $user->save();

        return redirect('user');
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
        // TODO: Since HTML forms can't make PUT, PATCH, or DELETE requests, you will need
        // to add a hidden  _method field to spoof these HTTP verbs. The
        // method_field helper can create this field for you:
        // {{ method_field('PUT') }}

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|integer|max:3',
            'phone' => 'numeric|phone|nullable',
        ]);

        if ($validator->fails()) {
            return redirect('user/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');

        $user->save();

        return redirect('user');
    }

    /**
     * Deletes a user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->trashed()) {
            // if the user was already deleted then permananetly delete it
            User::destroy($id);
        } else {
            // soft delete the user the first time
            $user->delete();
        }

        return redirect('user');
    }
    
    /**
     * Confirms deletion a user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function remove(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = "";
        
        return view('user.remove', [ 'user' => $user ]);
    }
}
