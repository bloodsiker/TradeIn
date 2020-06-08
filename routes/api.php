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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/brands', 'Api\ApiController@brand')->name('api.brands');
Route::get('/models', 'Api\ApiController@model')->name('api.models');
Route::get('/all-models', 'Api\ApiController@allModels')->name('api.all_models');
