<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		//$this->middleware('auth');
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

	/**
	 * Show the about page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function about()
	{
		return view('home.about');
	}

	/**
	 * Show the help page.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function help()
	{
		return view('home.help');
	}
}
