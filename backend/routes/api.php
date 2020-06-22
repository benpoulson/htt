<?php


// Auth managed inside controller
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::post('logout', 'AuthController@logout')->name('auth.logout');
    Route::post('refresh', 'AuthController@refresh')->name('auth.refresh');
    Route::get('user', 'AuthController@user')->name('auth.user');
});

Route::group(['auth:api'], function () {
    Route::group(['prefix' => 'shopify'], function () {
        Route::get('', 'Shopify\StoreController@list')->name('shopify.list');
        Route::post('', 'Shopify\StoreController@create')->name('shopify.create');
        Route::get('{shopifyStore}', 'Shopify\StoreController@view')->name('shopify.view');
        Route::post('{shopifyStore}', 'Shopify\StoreController@update')->name('shopify.update');
        Route::delete('{shopifyStore}', 'Shopify\StoreController@delete')->name('shopify.delete');

        Route::group(['prefix' => '{shopifyStore}/order'], function () {
            Route::get('', 'Shopify\OrderController@list')->name('shopify.order.list');
            Route::get('{orderId}', 'Shopify\OrderController@view')->name('shopify.order.view');
        });
    });
});
