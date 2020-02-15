<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// User Routes
Route::get('/users', 'UserController@getUsers');
Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::get('/verify_email/{uid}/{token}', 'UserController@verifyEmail');


// Structure Routes
Route::get('/structures', 'StructureController@index');

// Role Routes
Route::get('/roles', 'RoleController@index');


