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
Route::middleware('auth')->get('/reset-password/{id}', 'UserController@resetPassword');
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
Route::delete('/structure/{id}', 'StructureController@delete');

//Usagers Routes
Route::get('/structuresUsagers/{structureId}', 'UsagerController@getUsagersByStructure');

//Demandes
Route::post('/storeDemande', 'DemandeController@storeDemande');
Route::post('/listDemandes', 'DemandeController@getDemandes');
Route::get('/demande/{id}', 'DemandeController@getDemande');
Route::get('/affecterDemande/{id}', 'DemandeController@affecterDemande');

// Badge
Route::get('/badge-types', 'BadgeController@getBadgeTypes');

//Zone
Route::get('/zones', 'ZoneController@index');


// Role Routes
Route::get('/roles', 'RoleController@index');

// Cos Routes
Route::post('/cos/store', 'CosController@store');
Route::get('/cos/all', 'CosController@all');
Route::post('/cos/addDemande', 'CosController@addDemandeToCos');



