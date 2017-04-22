<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*-----------------------*
 *  Auth Controller     *
 *-----------------------*/
Auth::routes();


/*-----------------------*
 * Home Controller     *
 *-----------------------*/
Route::get('about', 'HomeController@showAbout');
Route::get('dashboard', 'HomeController@showDashboard');
Route::get('help', 'HomeController@showHelp');
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('login1', 'HomeController@showLogin1');
Route::get('register1', 'HomeController@showRegister1');
Route::get('unit', 'HomeController@showUnit');


