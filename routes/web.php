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

/*-----------------------*
 * User Controller       *
 *-----------------------*/
Route::resource('user', 'UserController');
Route::get('user/{id}/remove', 'UserController@remove');
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

/*-----------------------*
 * Device Controller       *
 *-----------------------*/
Route::resource('device', 'DeviceController');
Route::get('device/{id}/remove', 'DeviceController@remove');
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

/*-----------------------*
 * Dashboard Controller  *
 *-----------------------*/
Route::get('dashboard', 'DashboardController@index')->name('dashboard');

// Placeholders for NYI stuff
Route::get('unit', 'DashboardController@index')->name('unit');
Route::get('admin', 'DashboardController@index')->name('admin');
Route::get('manage-users', 'UserController@index')->name('manage-users');
Route::get('manage-groups', 'DashboardController@index')->name('manage-groups');
Route::get('manage-units', 'DashboardController@index')->name('manage-units');
Route::get('user-settings', 'DashboardController@index')->name('user-settings');
Route::get('user-notifications', 'DashboardController@index')->name('user-notifications');
