<?php

Route::prefix('/categories')->group(function () {
    Route::get('/', 'Api\CategoryController@index')->name('categories.index');
    Route::post('/', 'Api\CategoryController@store')->name('categories.store');
    Route::get('/{category}', 'Api\CategoryController@show')->name('categories.show');
    Route::put('/{category}', 'Api\CategoryController@update')->name('categories.update');
    Route::delete('/{category}', 'Api\CategoryController@destroy')->name('categories.destroy');
});

Route::prefix('/products')->group(function () {
    Route::get('/', 'Api\ProductController@index')->name('products.index');
    Route::post('/', 'Api\ProductController@store')->name('products.store');
    Route::get('/{product}', 'Api\ProductController@show')->name('products.show');
    Route::put('/{product}', 'Api\ProductController@update')->name('products.update');
    Route::delete('/{product}', 'Api\ProductController@destroy')->name('products.destroy');
});

Route::prefix('/access-roles')->group(function () {
    Route::get('/', 'Api\AccessRoleController@index')->name('roles.index');
    Route::post('/', 'Api\AccessRoleController@store')->name('roles.store');
    Route::get('/{role}', 'Api\AccessRoleController@show')->name('roles.show');
    Route::put('/{role}', 'Api\AccessRoleController@update')->name('roles.update');
    Route::delete('/{role}', 'Api\AccessRoleController@destroy')->name('roles.destroy');
});

Route::prefix('/users')->group(function () {
    Route::get('/', 'Api\UserController@index')->name('users.index');
    Route::post('/', 'Api\UserController@store')->name('users.store');
    Route::get('/{user}', 'Api\UserController@show')->name('users.show');
    Route::put('/{user}', 'Api\UserController@update')->name('users.update');
    Route::patch('/{user}', 'Api\UserController@change')->name('users.change');
    Route::delete('/{user}', 'Api\UserController@destroy')->name('users.destroy');
});

Route::prefix('/ticket-status')->group(function () {
    Route::get('/', 'Api\TicketStatusController@index')->name('ticket-status.index');
    Route::post('/', 'Api\TicketStatusController@store')->name('ticket-status.store');
    Route::get('/{status}', 'Api\TicketStatusController@show')->name('ticket-status.show');
    Route::put('/{status}', 'Api\TicketStatusController@update')->name('ticket-status.update');
    Route::delete('/{status}', 'Api\TicketStatusController@destroy')->name('ticket-status.destroy');
});

Route::prefix('/ticket-types')->group(function () {
    Route::get('/', 'Api\TicketTypeController@index')->name('ticket-types.index');
    Route::post('/', 'Api\TicketTypeController@store')->name('ticket-types.store');
    Route::get('/{type}', 'Api\TicketTypeController@show')->name('ticket-types.show');
    Route::put('/{type}', 'Api\TicketTypeController@update')->name('ticket-types.update');
    Route::delete('/{type}', 'Api\TicketTypeController@destroy')->name('ticket-types.destroy');
});

Route::prefix('/tickets')->group(function () {
    Route::get('/', 'Api\TicketController@index')->name('tickets.index');
    Route::post('/', 'Api\TicketController@store')->name('tickets.store');
    Route::get('/{ticket}', 'Api\TicketController@show')->name('tickets.show');
    Route::put('/{ticket}', 'Api\TicketController@update')->name('tickets.update');
    Route::patch('/{ticket}', 'Api\TicketController@close')->name('tickets.close');
});
