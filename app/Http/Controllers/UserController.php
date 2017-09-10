<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

    /* Auto route definitions for resource routes:
     * TYPE       URL                   METHOD   VIEW
     * ---------- --------------------- -------- -------------
     * GET	      /users                index    users.index
     * GET	      /users/create	        create   users.create
     * POST	      /users	            store	 users.store
     * GET	      /users/{id}           show     users.show
     * GET	      /users/{id}/edit      edit     users.edit
     * PUT/PATCH  /users/{id}           update   users.update
     * DELETE	  /users/{id}           destroy  users.destroy
     */

    /**
     * Display index page and process dataTable ajax request.
     *
     * @param \App\DataTables\UsersDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    /**
     * Show create user page.
     *
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'role' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('users/create')->withErrors($validator)->withInput();
        }

        //Auth::login($this->create($request->all()));

        return redirect('users');
    }

    /**
     * Update the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // TODO: Since HTML forms can't make PUT, PATCH, or DELETE requests, you will need
        // to add a hidden  _method field to spoof these HTTP verbs. The
        // method_field helper can create this field for you:
        // {{ method_field('PUT') }}

        // TODO: Use users model method to update record.
        return redirect('users');
    }
}
