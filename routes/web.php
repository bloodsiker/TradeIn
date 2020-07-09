<?php

use Illuminate\Support\Facades\Route;

//Auth::routes();

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'SiteController@index')->name('main');

    Route::match(['post', 'get'], '/login', 'LoginController@login')->name('login');
    Route::post('/auth', 'LoginController@auth')->name('auth');
    Route::match(['post', 'get'], '/password/reset', 'LoginController@resetPassword')->name('password.reset');
    Route::match(['post', 'get'], '/verify', 'LoginController@verify')->name('verify');
    Route::match(['post', 'get'], '/password/recovery', 'LoginController@passwordRecovery')->name('password.recovery');

    Route::get('/auth/{provider}', 'SocialAuthController@providerRedirect')->name('login.social');
    Route::get('/auth/facebook/callback', 'SocialAuthController@facebookCallback')->name('auth.facebook.callback');
    Route::get('/auth/google/callback', 'SocialAuthController@googleCallback')->name('auth.google.callback');
    Route::get('/auth/linkedin/callback', 'SocialAuthController@linkedinCallback')->name('auth.linkedin.callback');

    Route::group(['prefix' => 'cabinet', 'middleware' => ['auth', 'last_online']], function () {
        Route::get('/', 'Cabinet\MainController@index')->name('cabinet.main');


        Route::post('/get-ajax-date', 'Cabinet\AjaxController@getAjaxData')->name('cabinet.ajax_date');
        Route::get('/users', 'Cabinet\UserController@list')->name('cabinet.user.list')->middleware(['network']);

        Route::group(['middleware' => ['admin']], function () {

            Route::match(['post', 'get'], '/user/add', 'Cabinet\UserController@add')->name('cabinet.user.add');
            Route::match(['post', 'get'], '/user/{id}/edit', 'Cabinet\UserController@edit')->name('cabinet.user.edit');
            Route::post('/user/import', 'Cabinet\UserController@import')->name('cabinet.user.import');
            Route::post('/user/delete', 'Cabinet\UserController@delete')->name('cabinet.user.delete');

            Route::get('/networks', 'Cabinet\NetworkController@list')->name('cabinet.network.list');
            Route::post('/network/add', 'Cabinet\NetworkController@add')->name('cabinet.network.add');
            Route::post('/network/edit', 'Cabinet\NetworkController@edit')->name('cabinet.network.edit');
            Route::post('/network/delete', 'Cabinet\NetworkController@delete')->name('cabinet.network.delete');
            Route::get('/network/{id}/users', 'Cabinet\NetworkController@users')->name('cabinet.network.users');

            Route::get('/shops', 'Cabinet\ShopController@list')->name('cabinet.shop.list');
            Route::post('/shop/add', 'Cabinet\ShopController@add')->name('cabinet.shop.add');
            Route::post('/shop/edit', 'Cabinet\ShopController@edit')->name('cabinet.shop.edit');
            Route::post('/shop/delete', 'Cabinet\ShopController@delete')->name('cabinet.shop.delete');
            Route::post('/shop/import', 'Cabinet\ShopController@import')->name('cabinet.shop.import');
            Route::get('/shop/{id}/users', 'Cabinet\ShopController@users')->name('cabinet.shop.users');

            Route::get('/technic', 'Cabinet\TechnicController@list')->name('cabinet.technic.list');
            Route::post('/technic/add', 'Cabinet\TechnicController@add')->name('cabinet.technic.add');
            Route::post('/technic/edit', 'Cabinet\TechnicController@edit')->name('cabinet.technic.edit');
            Route::post('/technic/delete', 'Cabinet\TechnicController@delete')->name('cabinet.technic.delete');

            Route::get('/brands', 'Cabinet\BrandController@list')->name('cabinet.brand.list');
            Route::post('/brand/add', 'Cabinet\BrandController@add')->name('cabinet.brand.add');
            Route::post('/brand/edit', 'Cabinet\BrandController@edit')->name('cabinet.brand.edit');
            Route::post('/brand/delete', 'Cabinet\BrandController@delete')->name('cabinet.brand.delete');

            Route::get('/models', 'Cabinet\ModelController@list')->name('cabinet.model.list');
            Route::post('/model/add', 'Cabinet\ModelController@add')->name('cabinet.model.add');
            Route::post('/model/edit', 'Cabinet\ModelController@edit')->name('cabinet.model.edit');
            Route::post('/model/delete', 'Cabinet\ModelController@delete')->name('cabinet.model.delete');
            Route::post('/model/import', 'Cabinet\ModelController@import')->name('cabinet.model.import');

            Route::get('/buyback-bonus', 'Cabinet\BuybackBonusController@list')->name('cabinet.buyback_bonus.list');
            Route::post('/buyback-bonus/add', 'Cabinet\BuybackBonusController@add')->name('cabinet.buyback_bonus.add');
            Route::post('/buyback-bonus/edit', 'Cabinet\BuybackBonusController@edit')->name('cabinet.buyback_bonus.edit');
            Route::post('/buyback-bonus/delete', 'Cabinet\BuybackBonusController@delete')->name('cabinet.buyback_bonus.delete');
        });

        Route::get('/buyback-request', 'Cabinet\BuybackRequestController@list')->name('cabinet.buyback_request.list');
        Route::post('/buyback-request/add', 'Cabinet\BuybackRequestController@add')->name('cabinet.buyback_request.add');
        Route::post('/buyback-request/edit', 'Cabinet\BuybackRequestController@edit')->name('cabinet.buyback_request.edit');
        Route::post('/buyback-request/delete', 'Cabinet\BuybackRequestController@delete')->name('cabinet.buyback_request.delete')->middleware('admin');
        Route::post('/buyback-request/paid', 'Cabinet\BuybackRequestController@paid')->name('cabinet.buyback_request.paid')->middleware('admin');
        Route::post('/buyback-request/debt', 'Cabinet\BuybackRequestController@debt')->name('cabinet.buyback_request.debt')->middleware('admin');
        Route::post('/buyback-request/load-stock', 'Cabinet\BuybackRequestController@loadStock')->name('cabinet.buyback_request.load_stock');
        Route::get('/buyback-request/export', 'Cabinet\BuybackRequestController@export')->name('cabinet.buyback_request.export');
        Route::get('/buyback-request/pdf/{id}', 'Cabinet\BuybackRequestController@pdf')->name('cabinet.buyback_request.pdf');

        Route::match(['post', 'get'], '/nova-poshta', 'Cabinet\NovaPoshtaController@list')->name('cabinet.nova_poshta.list');
        Route::match(['post', 'get'], '/nova-poshta/counterparty', 'Cabinet\NovaPoshtaController@counterparty')->name('cabinet.nova_poshta.counterparty');
        Route::match(['post', 'get'], '/nova-poshta/add-ttn', 'Cabinet\NovaPoshtaController@addTtn')->name('cabinet.nova_poshta.add_ttn');
        Route::match(['post', 'get'], '/nova-poshta/add-ttn', 'Cabinet\NovaPoshtaController@addTtn')->name('cabinet.nova_poshta.add_ttn');

        Route::match(['post', 'get'], '/profile', 'Cabinet\ProfileController@profile')->name('cabinet.profile');
        Route::get('/bonus', 'Cabinet\ProfileController@bonus')->name('cabinet.profile.bonus');
        Route::get('/logout', 'Cabinet\ProfileController@logout')->name('cabinet.profile.logout');
        Route::get('/social/link', 'Cabinet\ProfileController@linkSocialAccount')->name('cabinet.profile.social_link');
        Route::get('/social/unlink', 'Cabinet\ProfileController@unlinkSocialAccount')->name('cabinet.profile.social_unlink');

        Route::get('/help', 'Cabinet\HelpController@list')->name('cabinet.help.list');
        Route::match(['post', 'get'], '/help/add', 'Cabinet\HelpController@add')->name('cabinet.help.add')->middleware('admin');
        Route::match(['post', 'get'], '/help/edit/{id}', 'Cabinet\HelpController@edit')->name('cabinet.help.edit')->middleware('admin');
        Route::post('/help/file/delete/', 'Cabinet\HelpController@deleteFile')->name('cabinet.help.delete_file')->middleware('admin');
        Route::get('/help/delete/{id}', 'Cabinet\HelpController@delete')->name('cabinet.help.delete')->middleware('admin');
        Route::post('/help/upload', 'Cabinet\HelpController@upload')->name('cabinet.help.upload')->middleware('admin');
        Route::get('/help/{id}', 'Cabinet\HelpController@view')->name('cabinet.help.view');

        Route::get('/model-requests', 'Cabinet\ModelRequestController@list')->name('cabinet.model_request.list');
        Route::post('/model-request/add', 'Cabinet\ModelRequestController@add')->name('cabinet.model_request.add');
        Route::post('/model-request/edit', 'Cabinet\ModelRequestController@edit')->name('cabinet.model_request.edit');
        Route::post('/model-request/delete', 'Cabinet\ModelRequestController@delete')->name('cabinet.model_request.delete');

        Route::get('/chat', 'Cabinet\ChatController@index')->name('cabinet.chat.index');
        Route::post('/chat/load', 'Cabinet\ChatController@chatLoad')->name('cabinet.chat.load');
        Route::post('/chat/group/add', 'Cabinet\ChatController@groupAdd')->name('cabinet.chat.group_add');
        Route::post('/chat/invite/user', 'Cabinet\ChatController@inviteUser')->name('cabinet.chat.invite_user');
        Route::match(['post', 'get'], '/chat/{uniq_id}', 'Cabinet\ChatController@view')->name('cabinet.chat.view');
    });
});
