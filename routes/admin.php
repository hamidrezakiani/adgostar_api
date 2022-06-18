<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Controller;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ItemController;
Route::resource('login', 'Auth\LoginController');
Route::group(['middleware' => 'auth:admin'], function () {
    Route::resource('account', 'AdminController');
    Route::resource('categories','CategoryController');
    Route::post('categories/move-up/{id}',[CategoryController::class,'moveUp']);
    Route::post('categories/move-down/{id}',[CategoryController::class,'moveDown']);
    Route::post('products/move-up/{id}',[ProductController::class,'moveUp']);
    Route::post('products/move-down/{id}',[ProductController::class,'moveDown']);
    Route::post('items/move-up/{id}',[ItemController::class,'moveUp']);
    Route::post('items/move-down/{id}',[ItemController::class,'moveDown']);
    Route::resource('products', 'ProductController');
    Route::resource('items', 'ItemController');
    Route::resource('itemParticipation', 'ItemParticipationController');
    Route::resource('itemPeriods', 'ItemPeriodController');
    Route::resource('properties', 'PropertyController');
    Route::resource('participations', 'ParticipationController');
    Route::resource('participationPeriods', 'ParticipationPeriodController');
});


Route::get('key',function (){
    Artisan::call('key:generate');
});