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
Route::middleware('auth')->get('/users', 'UserController@getUsers');
Route::middleware('auth')->post('/register', 'UserController@register');
Route::post('/authenticate', 'UserController@authenticate');
Route::get('/verify_email/{uid}/{token}', 'UserController@verifyEmail');
Route::middleware('auth')->put('/user/update', 'UserController@updateUser');
Route::middleware('auth')->delete('/user/delete/{id}', 'UserController@deleteUser');
Route::middleware('auth')->get('/auth-user', 'UserController@getAuth');
Route::middleware('auth')->get('/is-auth', 'UserController@verifyToken');


// Structure Routes
Route::get('/structures', 'StructureController@index');
Route::post('/structure', 'StructureController@store');
Route::put('/structure', 'StructureController@update');

// Role Routes
Route::get('/roles', 'RoleController@index');


