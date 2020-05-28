<?php

use CQ\Middleware\JSON;
use CQ\Middleware\Session;
use CQ\Routing\Middleware;
use CQ\Routing\Route;

Route::$router = $router->get();
Middleware::$router = $router->get();

Route::get('/', 'GeneralController@index');
Route::get('/error/{code}', 'GeneralController@error');

Middleware::create(['prefix' => '/auth'], function () {
    Route::get('/request', 'AuthController@request');
    Route::get('/callback', 'AuthController@callback');
    Route::get('/logout', 'AuthController@logout');
});

Middleware::create(['middleware' => [Session::class]], function () {
    Route::get('/dashboard', 'UserController@dashboard');
});

Route::get('/{short_url}/?{option?}', 'UrlController@index');
Middleware::create(['prefix' => '/url', 'middleware' => [Session::class]], function () {
    Route::post('', 'UrlController@create', JSON::class);
    Route::patch('/{id}', 'UrlController@update', JSON::class);
    Route::delete('/{id}', 'UrlController@delete');
});
