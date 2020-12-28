<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'HomeController@login')->name('index');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::resource('/customers', 'CustomerController')->name('*','customers')->middleware('auth');
Route::resource('/groups', 'GroupController')->name('*','groups')->middleware('auth');
Route::resource('/offers', 'OfferController')->name('*','offers')->middleware('auth');


Route::post('/update_offer_status', 'OfferController@update_offer_status')->name('offers.update_offer_status')->middleware('auth');
Route::post('/send_notification', 'OfferController@send_notification')->name('offers.send_notification')->middleware('auth');

