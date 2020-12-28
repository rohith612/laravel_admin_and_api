<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::get('/test', 'Api\CustomerAppController@test');
Route::post('/login', 'Api\CustomerAppController@login');
Route::post('/login_verify', 'Api\CustomerAppController@authenticate_user');
Route::post('/offer_glance', 'Api\CustomerAppController@offer_glance');


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
