<?php

Route::prefix('/categories')->group(function () {
    Route::get('/', 'CategoryController@index')->name('categories.index');
    Route::post('/', 'CategoryController@store')->name('categories.store');
    Route::get('/{category}', 'CategoryController@show')->name('categories.show');
    Route::put('/{category}', 'CategoryController@update')->name('categories.update');
    Route::delete('/{category}', 'CategoryController@destroy')->name('categories.destroy');
});

Route::prefix('/products')->group(function () {
    Route::get('/', 'ProductController@index')->name('products.index');
    Route::post('/', 'ProductController@store')->name('products.store');
    Route::get('/{product}', 'ProductController@show')->name('products.show');
    Route::put('/{product}', 'ProductController@update')->name('products.update');
    Route::delete('/{product}', 'ProductController@destroy')->name('products.destroy');
});

Route::prefix('/access-roles')->group(function () {
    Route::get('/', 'AccessRoleController@index')->name('roles.index');
    Route::post('/', 'AccessRoleController@store')->name('roles.store');
    Route::get('/{role}', 'AccessRoleController@show')->name('roles.show');
    Route::put('/{role}', 'AccessRoleController@update')->name('roles.update');
    Route::delete('/{role}', 'AccessRoleController@destroy')->name('roles.destroy');
});

Route::prefix('/users')->group(function () {
    Route::get('/', 'UserController@index')->name('users.index');
    Route::post('/', 'UserController@store')->name('users.store');
    Route::get('/{user}', 'UserController@show')->name('users.show');
    Route::put('/{user}', 'UserController@update')->name('users.update');
    Route::patch('/{user}', 'UserController@change')->name('users.change');
    Route::delete('/{user}', 'UserController@destroy')->name('users.destroy');
});

Route::prefix('/ticket-status')->group(function () {
    Route::get('/', 'TicketStatusController@index')->name('ticket-status.index');
    Route::post('/', 'TicketStatusController@store')->name('ticket-status.store');
    Route::get('/{status}', 'TicketStatusController@show')->name('ticket-status.show');
    Route::put('/{status}', 'TicketStatusController@update')->name('ticket-status.update');
    Route::delete('/{status}', 'TicketStatusController@destroy')->name('ticket-status.destroy');
});

Route::prefix('/ticket-types')->group(function () {
    Route::get('/', 'TicketTypeController@index')->name('ticket-types.index');
    Route::post('/', 'TicketTypeController@store')->name('ticket-types.store');
    Route::get('/{type}', 'TicketTypeController@show')->name('ticket-types.show');
    Route::put('/{type}', 'TicketTypeController@update')->name('ticket-types.update');
    Route::delete('/{type}', 'TicketTypeController@destroy')->name('ticket-types.destroy');
});

Route::prefix('/tickets')->group(function () {
    Route::get('/', 'TicketController@index')->name('tickets.index');
    Route::post('/', 'TicketController@store')->name('tickets.store');
    Route::get('/{ticket}', 'TicketController@show')->name('tickets.show');
    Route::put('/{ticket}', 'TicketController@update')->name('tickets.update');
    Route::patch('/{ticket}', 'TicketController@close')->name('tickets.close');
});
