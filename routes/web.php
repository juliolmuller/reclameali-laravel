<?php

Route::VIEW('/', 'index')->name('index');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/signin', 'AuthController@signin')->name('auth.signin');

Route::post('/signout', 'AuthController@signout')->name('auth.signout');
