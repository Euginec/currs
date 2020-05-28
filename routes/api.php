<?php

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

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@registration');

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'rates'], function ($router) {
    Route::get('/current', 'Api\ExchangeRateController@getCurrentRate');
    Route::post('/history', 'Api\ExchangeRateController@getHistory');
});

Route::group([
    'middleware' => 'auth:api'
], function ($router) {
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('refresh', 'Api\AuthController@refresh');
});
