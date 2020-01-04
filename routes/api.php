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
