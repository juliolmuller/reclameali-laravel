<?php

Route::group(['prefix' => '/categories', 'as' => 'categories.'], function () {
    Route::get('/', 'Api\CategoriesApiController@index')->name('index');
    Route::post('/', 'Api\CategoriesApiController@store')->name('store');
    Route::get('/{category}', 'Api\CategoriesApiController@show')->name('show');
    Route::put('/{category}', 'Api\CategoriesApiController@update')->name('update');
    Route::delete('/{category}', 'Api\CategoriesApiController@destroy')->name('destroy');
});

Route::group(['prefix' => '/products', 'as' => 'products.'], function () {
    Route::get('/', 'Api\ProductsApiController@index')->name('index');
    Route::post('/', 'Api\ProductsApiController@store')->name('store');
    Route::get('/{product}', 'Api\ProductsApiController@show')->name('show');
    Route::put('/{product}', 'Api\ProductsApiController@update')->name('update');
    Route::delete('/{product}', 'Api\ProductsApiController@destroy')->name('destroy');
});

Route::group(['prefix' => '/access-roles', 'as' => 'roles.'], function () {
    Route::get('/', 'Api\AccessRolesApiController@index')->name('index');
    Route::post('/', 'Api\AccessRolesApiController@store')->name('store');
    Route::get('/{role}', 'Api\AccessRolesApiController@show')->name('show');
    Route::put('/{role}', 'Api\AccessRolesApiController@update')->name('update');
    Route::delete('/{role}', 'Api\AccessRolesApiController@destroy')->name('destroy');
});

Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
    Route::get('/', 'Api\UsersApiController@index')->name('index');
    Route::post('/', 'Api\UsersApiController@store')->name('store');
    Route::get('/{user}', 'Api\UsersApiController@show')->name('show');
    Route::put('/{user}', 'Api\UsersApiController@updateData')->name('update-data');
    Route::patch('/{user}', 'Api\UsersApiController@udpatePassword')->name('update-password');
    Route::delete('/{user}', 'Api\UsersApiController@destroy')->name('destroy');
});

Route::group(['prefix' => '/ticket-status', 'as' => 'ticket-status.'], function () {
    Route::get('/', 'Api\TicketStatusApiController@index')->name('index');
    Route::post('/', 'Api\TicketStatusApiController@store')->name('store');
    Route::get('/{status}', 'Api\TicketStatusApiController@show')->name('show');
    Route::put('/{status}', 'Api\TicketStatusApiController@update')->name('update');
    Route::delete('/{status}', 'Api\TicketStatusApiController@destroy')->name('destroy');
});

Route::group(['prefix' => '/ticket-types', 'as' => 'ticket-types.'], function () {
    Route::get('/', 'Api\TicketTypesApiController@index')->name('index');
    Route::post('/', 'Api\TicketTypesApiController@store')->name('store');
    Route::get('/{type}', 'Api\TicketTypesApiController@show')->name('show');
    Route::put('/{type}', 'Api\TicketTypesApiController@update')->name('update');
    Route::delete('/{type}', 'Api\TicketTypesApiController@destroy')->name('destroy');
});

Route::group(['prefix' => '/tickets', 'as' => 'tickets.'], function () {
    Route::get('/', 'Api\TicketsApiController@index')->name('index');
    Route::post('/', 'Api\TicketsApiController@store')->name('store');
    Route::get('/{ticket}', 'Api\TicketsApiController@show')->name('show');
    Route::put('/{ticket}', 'Api\TicketsApiController@update')->name('update');
    Route::patch('/{ticket}', 'Api\TicketsApiController@close')->name('close');
});
