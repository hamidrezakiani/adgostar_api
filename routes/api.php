<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Executer\ExecuterController;
use App\Http\Controllers\Representation\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth:user'], function () {
    Route::resource('user',UserController::class);
});

Route::group(['middleware' => 'auth:executer'], function () {
    Route::resource('executer', ExecuterController::class);
});

