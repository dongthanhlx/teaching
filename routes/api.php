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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('register', 'JWTAuthController@register');
Route::post('login', 'JWTAuthController@login');
Route::post('logout', 'JWTAuthController@logout');
Route::get('user', 'UserController@index');
Route::post('upload', 'GoogleDriveController@store');
Route::put('userDetail/{id}', 'UserDetailController@updpate');
