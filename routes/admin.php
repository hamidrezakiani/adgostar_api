<?php

use Illuminate\Support\Facades\Route;

Route::resource('login', 'Auth\LoginController');
Route::group(['middleware' => 'auth:admin'], function () {
    Route::resource('categories','CategoryController');
    Route::resource('products', 'ProductController');
    Route::resource('items', 'ItemController');
    Route::resource('itemPeriods', 'ItemPeriodController');
    Route::resource('properties', 'PropertyController');
    Route::resource('participations', 'ParticipationController');
    Route::resource('participationPeriods', 'ParticipationPeriodController');
});

