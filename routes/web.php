<?php

Route::get('/', 'HomeController@index')->name('index');

Route::get('/home', 'HomeController@dashboard')->name('home');

Route::post('/signin', 'AuthController@signin')->name('auth.signin');

Route::post('/signout', 'AuthController@signout')->name('auth.signout');
