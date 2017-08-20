<?php

use App\DataTables\UsersDataTable;

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
 *  Auth Controller      *
 *-----------------------*/
Auth::routes();

/*-----------------------*
 * Home Controller       *
 *-----------------------*/
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');
Route::get('about', 'HomeController@about')->name('about');
Route::get('help', 'HomeController@help')->name('help');
Route::get('dashboard', 'DashboardController@index')->name('dashboard');

/*-----------------------*
 * User Controller       *
 *-----------------------*/
// Route::get('users', function index(UsersDataTable $dataTable) {
//     return $dataTable->render('users.index');
// });

Route::resource('users', 'UsersController');

/*-----------------------*
 * Dashboard Controller  *
 *-----------------------*/

// Placeholders for NYI stuff
Route::get('unit', 'DashboardController@index')->name('unit');
Route::get('admin', 'DashboardController@index')->name('admin');
Route::get('manage-users', 'DashboardController@index')->name('manage-users');
Route::get('manage-groups', 'DashboardController@index')->name('manage-groups');
Route::get('manage-units', 'DashboardController@index')->name('manage-units');
Route::get('user-settings', 'DashboardController@index')->name('user-settings');
Route::get('user-notifications', 'DashboardController@index')->name('user-notifications');
