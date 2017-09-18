<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*-----------------------*
 * api/register          *
 *-----------------------*/
Route::get('register', 'ApiController@index');
Route::post('register', 'ApiController@register');


/*-----------------------*
 * api/update            *
 *-----------------------*/
Route::get('update', 'ApiController@index');
Route::post('update', 'ApiController@update');

/*-----------------------*
 * api/show/{id}         *
 *-----------------------*/
 Route::get('show', 'ApiController@index');
 Route::get('show/{device}', 'ApiController@show');