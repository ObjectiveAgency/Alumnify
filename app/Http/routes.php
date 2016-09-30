<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'LandingController@index');

// authentication routes
Route::auth();

// dashboard routes
Route::get('/dashboard', 'DashboardController@index');

// campaign routes
Route::get('/campaign', 'CampaignController@index');

// subscribers routes
Route::get('/subscribers', 'SubscriberController@index');

// connections routes
Route::get('/connections', 'ConnectionController@index');
//<<<<<<< Updated upstream

// profile routes
Route::get('/profile', 'ProfileController@index');

Route::post('/profile/update', 'ProfileController@update');

Route::post('/profile/update/image', 'ProfileController@updateImage');

// settings routes
Route::get('/settings', 'SettingsController@index');

Route::post('/settings/update/email', 'SettingsController@changeEmail');

Route::post('/settings/update/password', 'SettingsController@changePass');

Route::get('OAuth','SubscriberController@getList');

// members trial function
Route::get('{loc}',"test@test");

//>>>>>>> Stashed changes
