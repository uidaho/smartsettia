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
Route::put('user/{id}/restore', 'UserController@restore')->name('user.restore');
Route::resource('user', 'UserController');
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
Route::put('device/{id}/restore', 'DeviceController@restore')->name('device.restore');
Route::resource('device', 'DeviceController');

/*-----------------------*
 * Dashboard Controller  *
 *-----------------------*/
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('dev_layout', 'DashboardController@dev_layout');

/*-----------------------*
 * Activity Log Controller *
 *-----------------------*/
Route::get('logs', 'ActivityLogController@index')->name('logs');

/*-----------------------*
 * Sensor Controller *
 *-----------------------*/
Route::resource('sensor', 'SensorController');

/*-----------------------*
 * SensorData Controller *
 *-----------------------*/
Route::resource('sensordata', 'SensorDataController');

/*-----------------------*
 * Image Controller  *
 *-----------------------*/
Route::get('image/device/{device_id}', 'ImageController@show')->name('image.device');

/*-----------------------*
 * Location Controller *
 *-----------------------*/
Route::resource('location', 'LocationController');

/*-----------------------*
 * Site Controller *
 *-----------------------*/
Route::resource('site', 'SiteController');

/*-----------------------*
 * SMS Controller *
 *-----------------------*/
Route::get('/sms/send/{to}', function(\Nexmo\Client $nexmo, $to){
    $message = $nexmo->message()->send([
        'to' => $to,
        'from' => env('NEXMO_FROM'),
        'text' => 'This is a test sms message from SmartSettia.'
    ]);
    Log::info('sent message: ' . $message['message-id']);
});
Route::post('/sms/receive', function(\Nexmo\Client $nexmo){
    $message = \Nexmo\Message\InboundMessage::createFromGlobals();
    Log::info('got text: ' . $message->getBody());
    $reply =$nexmo->message()->send($message->createReply('This is for SmartSettia notifications only. Please contact admin@smartsettia.com for assistance.'));
    Log::info('sent reply: ' . $reply['message-id']);
});

// TODO
Route::get('unit', 'DashboardController@index')->name('unit');
Route::get('admin', 'DashboardController@index')->name('admin');
Route::get('user-notifications', 'DashboardController@index')->name('user-notifications');
