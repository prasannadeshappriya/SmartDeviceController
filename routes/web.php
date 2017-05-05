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

Route::get('/',array(
    'as' => 'ViewIndexPage',
    'uses' => 'DeviceController@index'
));

Route::post('buffer',array(
    'as' => 'SendGestureDetails',
    'uses' => 'DeviceController@inputData'
));

Route::post('connect',array(
    'as' => 'ConnectDevice',
    'uses' => 'DeviceController@connect'
));

Route::post('disconnect',array(
    'as' => 'DisconnectDevice',
    'uses' => 'DeviceController@disconnect'
));