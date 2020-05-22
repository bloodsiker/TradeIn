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


//Auth::routes();

Route::group(['middleware' => ['web']], function (){
    Route::get('/', 'SiteController@index')->name('main');
//    Route::get('about', 'SiteController@getAbout')->name('about');
//    Route::get('support', 'SiteController@getSupport')->name('support');
//    Route::post('support', 'SiteController@postSupport')->name('support');
//
//
//    Route::post('forms/main', 'FormsController@mainHelpRequest')->name('form.main.help');
//    Route::post('forms/sc', 'FormsController@ScRequest')->name('form.sc');
//    Route::get('html', 'FormsController@html')->name('form.sc');
//
//    Route::get('user/login', 'LoginController@getUserLogin')->name('user.login');
//    Route::post('user/login', 'LoginController@postUserLogin')->name('user.login');
//    Route::get('user/registration', 'RegisterController@getUserIndex')->name('user.registration');
//    Route::post('user/registration', 'RegisterController@postUserRegister')->name('user.registration');
//
//    Route::get('service-center/login', 'LoginController@getServiceLogin')->name('service.login');
//    Route::post('service-center/login', 'LoginController@postServiceLogin')->name('service.login');
//    Route::get('service-center/registration', 'RegisterController@getServiceRegister')->name('service.registration');
//    Route::post('service-center/registration', 'RegisterController@postServiceRegister')->name('service.registration');
//
//    Route::get('user/password/recovery', 'RecoveryPasswordController@getRecovery')->name('user.password.recovery');
//    Route::post('user/password/send-email', 'RecoveryPasswordController@sendResetLinkEmail')->name('user.password.send-email');

});

Route::group(['middleware' => ['web']], function () {
    Route::group(['prefix' => 'cabinet'], function () {
        Route::get('/', 'Cabinet\MainController@index')->name('cabinet.main');

        Route::get('/users', 'Cabinet\UserController@list')->name('cabinet.user.list');
        Route::match(['post', 'get'], '/user/add', 'Cabinet\UserController@add')->name('cabinet.user.add');
        Route::match(['post', 'get'], '/user/{id}/edit', 'Cabinet\UserController@edit')->name('cabinet.user.edit');
        Route::get('/user/{id}/delete', 'Cabinet\UserController@delete')->name('cabinet.user.delete');


        Route::get('/networks', 'Cabinet\NetworkController@list')->name('cabinet.network.list');
        Route::post('/network/add', 'Cabinet\NetworkController@add')->name('cabinet.network.add');
        Route::match(['post', 'get'], '/network/{id}/edit', 'Cabinet\NetworkController@edit')->name('cabinet.network.edit');
        Route::get('/network/{id}/delete', 'Cabinet\NetworkController@delete')->name('cabinet.network.delete');
    });
});
