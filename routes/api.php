<?php

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [SignUpController::class, 'login']);
Route::post('signup', [SignUpController::class, 'signUp']);
Route::middleware('auth:api')->group( function () {

    ///////weather api/////////
    Route::post('current-temperature', [WeatherController::class, 'getCurrentTemperature']);

    //////gallery////////////////
    Route::post('gallery/create', [GallaryController::class, 'create']);
    Route::post('gallery/view', [GallaryController::class, 'view']);
    Route::post('gallery/update', [GallaryController::class, 'update']);
    Route::post('gallery/delete', [GallaryController::class, 'delete']);
   
   ///////////community/////////
    Route::post('community/view', [CommunityController::class,   'view']);
    Route::post('community/create', [CommunityController::class, 'create']);
    Route::post('community/update', [CommunityController::class, 'update']);
    Route::post('community/delete', [CommunityController::class, 'delete']);
});