<?php

use Illuminate\Support\Facades\Route;

//Auth::routes();

Route::group(['middleware' => ['web']], function (){
//    Route::get('about', 'SiteController@getAbout')->name('about');
//    Route::get('support', 'SiteController@getSupport')->name('support');
//    Route::post('support', 'SiteController@postSupport')->name('support');
//
//
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

    Route::get('/', 'SiteController@index')->name('main');

    Route::match(['post', 'get'], '/login', 'LoginController@login')->name('login');
    Route::match(['post', 'get'], '/reset-password', 'LoginController@resetPassword')->name('reset_password');

    Route::get('/auth/{provider}', 'SocialAuthController@providerRedirect')->name('provider.redirect');
    Route::get('/auth/facebook/callback', 'SocialAuthController@facebookCallback')->name('auth.facebook.callback');
    Route::get('/auth/google/callback', 'SocialAuthController@googleCallback')->name('auth.google.callback');
    Route::get('/auth/linkedin/callback', 'SocialAuthController@linkedinCallback')->name('auth.linkedin.callback');

    Route::group(['prefix' => 'cabinet', 'middleware' => ['auth']], function () {
        Route::get('/', 'Cabinet\MainController@index')->name('cabinet.main');

        Route::group(['middleware' => ['admin']], function () {
            Route::get('/users', 'Cabinet\UserController@list')->name('cabinet.user.list');
            Route::match(['post', 'get'], '/user/add', 'Cabinet\UserController@add')->name('cabinet.user.add');
            Route::match(['post', 'get'], '/user/{id}/edit', 'Cabinet\UserController@edit')->name('cabinet.user.edit');
            Route::post('/user/delete', 'Cabinet\UserController@delete')->name('cabinet.user.delete');
            Route::post('/user/get-ajax-date', 'Cabinet\UserController@getAjaxData')->name('cabinet.user.ajax_date');

            Route::get('/networks', 'Cabinet\NetworkController@list')->name('cabinet.network.list');
            Route::post('/network/add', 'Cabinet\NetworkController@add')->name('cabinet.network.add');
            Route::post('/network/edit', 'Cabinet\NetworkController@edit')->name('cabinet.network.edit');
            Route::post('/network/delete', 'Cabinet\NetworkController@delete')->name('cabinet.network.delete');
            Route::get('/network/{id}/users', 'Cabinet\NetworkController@users')->name('cabinet.network.users');

            Route::get('/shops', 'Cabinet\ShopController@list')->name('cabinet.shop.list');
            Route::post('/shop/add', 'Cabinet\ShopController@add')->name('cabinet.shop.add');
            Route::post('/shop/edit', 'Cabinet\ShopController@edit')->name('cabinet.shop.edit');
            Route::post('/shop/delete', 'Cabinet\ShopController@delete')->name('cabinet.shop.delete');
            Route::get('/shop/{id}/users', 'Cabinet\ShopController@users')->name('cabinet.shop.users');

            Route::get('/brands', 'Cabinet\BrandController@list')->name('cabinet.brand.list');
            Route::post('/brand/add', 'Cabinet\BrandController@add')->name('cabinet.brand.add');
            Route::post('/brand/edit', 'Cabinet\BrandController@edit')->name('cabinet.brand.edit');
            Route::post('/brand/delete', 'Cabinet\BrandController@delete')->name('cabinet.brand.delete');

            Route::get('/models', 'Cabinet\ModelController@list')->name('cabinet.model.list');
            Route::post('/model/add', 'Cabinet\ModelController@add')->name('cabinet.model.add');
            Route::post('/model/edit', 'Cabinet\ModelController@edit')->name('cabinet.model.edit');
            Route::post('/model/delete', 'Cabinet\ModelController@delete')->name('cabinet.model.delete');

            Route::get('/buyback-bonus', 'Cabinet\BuybackBonusController@list')->name('cabinet.buyback_bonus.list');
            Route::post('/buyback-bonus/add', 'Cabinet\BuybackBonusController@add')->name('cabinet.buyback_bonus.add');
            Route::post('/buyback-bonus/edit', 'Cabinet\BuybackBonusController@edit')->name('cabinet.buyback_bonus.edit');
            Route::post('/buyback-bonus/delete', 'Cabinet\BuybackBonusController@delete')->name('cabinet.buyback_bonus.delete');
        });

        Route::get('/buyback-request', 'Cabinet\BuybackRequestController@list')->name('cabinet.buyback_request.list');
        Route::post('/buyback-request/add', 'Cabinet\BuybackRequestController@add')->name('cabinet.buyback_request.add');
        Route::post('/buyback-request/edit', 'Cabinet\BuybackRequestController@edit')->name('cabinet.buyback_request.edit');
        Route::post('/buyback-request/delete', 'Cabinet\BuybackRequestController@delete')->name('cabinet.buyback_request.delete');

        Route::match(['post', 'get'], '/profile', 'Cabinet\ProfileController@profile')->name('cabinet.profile');
        Route::get('/logout', 'Cabinet\ProfileController@logout')->name('cabinet.profile.logout');

        Route::get('/model-requests', 'Cabinet\ModelRequestController@list')->name('cabinet.model_request.list');
        Route::post('/model-request/add', 'Cabinet\ModelRequestController@add')->name('cabinet.model_request.add');
        Route::post('/model-request/edit', 'Cabinet\ModelRequestController@edit')->name('cabinet.model_request.edit');
        Route::post('/model-request/delete', 'Cabinet\ModelRequestController@delete')->name('cabinet.model_request.delete');
    });
});
