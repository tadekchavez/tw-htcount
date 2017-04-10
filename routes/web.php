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

Route::get('/', "HtCount@show");
Route::get('/twCallback', "Twitter@twCallback");
Route::get('/authApp', "Twitter@authApp");
Route::get('/show10', "Twitter@show10Tweets");