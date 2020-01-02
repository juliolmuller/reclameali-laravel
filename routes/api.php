<?php

use Illuminate\Http\Request;

Route::prefix('/categories')->group(function () {
    Route::get('/', 'CategoryController@index')->name('categories.index');
    Route::post('/', 'CategoryController@store')->name('categories.store');
    Route::get('/{category}', 'CategoryController@show')->name('categories.show');
    Route::put('/{category}', 'CategoryController@update')->name('categories.update');
    Route::delete('/{category}', 'CategoryController@destroy')->name('categories.destroy');
});
