<?php

Route::group(['prefix' => '/categories', 'as' => 'categories.'], function () {
    Route::get('/', 'Api\CategoryController@index')->name('index');
    Route::post('/', 'Api\CategoryController@store')->name('store');
    Route::get('/{category}', 'Api\CategoryController@show')->name('show');
    Route::put('/{category}', 'Api\CategoryController@update')->name('update');
    Route::delete('/{category}', 'Api\CategoryController@destroy')->name('destroy');
});

Route::group(['prefix' => '/products', 'as' => 'products.'], function () {
    Route::get('/', 'Api\ProductController@index')->name('index');
    Route::post('/', 'Api\ProductController@store')->name('store');
    Route::get('/{product}', 'Api\ProductController@show')->name('show');
    Route::put('/{product}', 'Api\ProductController@update')->name('update');
    Route::delete('/{product}', 'Api\ProductController@destroy')->name('destroy');
});

Route::group(['prefix' => '/access-roles', 'as' => 'roles.'], function () {
    Route::get('/', 'Api\AccessRoleController@index')->name('index');
    Route::post('/', 'Api\AccessRoleController@store')->name('store');
    Route::get('/{role}', 'Api\AccessRoleController@show')->name('show');
    Route::put('/{role}', 'Api\AccessRoleController@update')->name('update');
    Route::delete('/{role}', 'Api\AccessRoleController@destroy')->name('destroy');
});

Route::group(['prefix' => '/ticket-status', 'as' => 'ticket-status.'], function () {
    Route::get('/', 'Api\TicketStatusController@index')->name('index');
    Route::post('/', 'Api\TicketStatusController@store')->name('store');
    Route::get('/{status}', 'Api\TicketStatusController@show')->name('show');
    Route::put('/{status}', 'Api\TicketStatusController@update')->name('update');
    Route::delete('/{status}', 'Api\TicketStatusController@destroy')->name('destroy');
});

Route::group(['prefix' => '/ticket-types', 'as' => 'ticket-types.'], function () {
    Route::get('/', 'Api\TicketTypeController@index')->name('index');
    Route::post('/', 'Api\TicketTypeController@store')->name('store');
    Route::get('/{type}', 'Api\TicketTypeController@show')->name('show');
    Route::put('/{type}', 'Api\TicketTypeController@update')->name('update');
    Route::delete('/{type}', 'Api\TicketTypeController@destroy')->name('destroy');
});

Route::group(['prefix' => '/tickets', 'as' => 'tickets.'], function () {
    Route::get('/', 'Api\TicketController@index')->name('index');
    Route::post('/', 'Api\TicketController@store')->name('store');
    Route::get('/{ticket}', 'Api\TicketController@show')->name('show');
    Route::put('/{ticket}', 'Api\TicketController@update')->name('update');
    Route::patch('/{ticket}', 'Api\TicketController@close')->name('close');
});
