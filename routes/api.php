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
        Route::get('', 'ShopifyStoreController@list')->name('shopify.list');
        Route::post('', 'ShopifyStoreController@create')->name('shopify.create');
        Route::get('{shopifyStore}', 'ShopifyStoreController@view')->name('shopify.view');
        Route::post('{shopifyStore}', 'ShopifyStoreController@update')->name('shopify.update');
        Route::delete('{shopifyStore}', 'ShopifyStoreController@delete')->name('shopify.delete');
    });
});
