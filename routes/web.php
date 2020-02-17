<?php

Route::get('/', 'HomeController@index')->name('index');

Route::get('/home', 'HomeController@dashboard')->name('home');

Route::post('/signin', 'AuthController@signin')->name('auth.signin');
Route::post('/signout', 'AuthController@signout')->name('auth.signout');

Route::get('/atendimentos', fn() => view('tickets-index'))->name('page.tickets');
Route::get('/meus-dados', fn() => view('user-data'))->name('page.manage_data');
Route::get('/categorias', fn() => view('categories'))->name('page.categories');
Route::get('/produtos', fn() => view('products'))->name('page.products');
Route::get('/atendimentos-opcoes', fn() => view('ticket-options-index'))->name('page.ticket_options');
Route::get('/usuarios', fn() => view('users'))->name('page.users');
