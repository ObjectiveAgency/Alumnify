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

Route::auth();

Route::get('/dashboard', 'DashboardController@index');

Route::get('/campaign', 'CampaignController@index');

Route::get('/subscribers', 'SubscriberController@index');

Route::get('/connections', 'ConnectionController@index');
