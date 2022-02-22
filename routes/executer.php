<?php

use App\Http\Controllers\Executer\CategoryController;
use App\Http\Controllers\Executer\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('login', 'Auth\LoginController');
Route::group(['middleware' => 'auth:executer'], function () {
   Route::get('categories',[CategoryController::class,'index']);
   Route::get('products', [ProductController::class, 'index']);
   Route::resource('participations','ParticipationController');
   Route::resource('participations.periods','PeriodController');
    Route::resource('orders', 'OrderController');
   Route::get('ip',function(Request $request){return $request->ip();});
});
