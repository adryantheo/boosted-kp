<?php

use Illuminate\Http\Request;

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::post('/upload-image', 'ProductController@uploadImage');



Route::get('/users','UserController@index');
Route::get('users/{user}','UserController@show');
Route::patch('users/{user}','UserController@update');
Route::get('users/{user}/orders','UserController@showOrders');
Route::get('/stands/random', 'StandController@random');
Route::get('/products/random', 'ProductController@random');


Route::resource('/orders', 'OrderController');
Route::resource('/stands', 'StandController')->except(['random']);
Route::resource('/products', 'ProductController')->except(['random', 'uploadImage']);