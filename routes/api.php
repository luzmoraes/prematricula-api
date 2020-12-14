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

// Route::group([
//     'namespace' => 'Auth\\',
//     'middleware' => 'api',
// ], function () {
//     Route::post('create', 'PasswordResetController@create');
//     Route::get('find/{token}', 'PasswordResetController@find');
//     Route::post('reset', 'PasswordResetController@reset');
// });

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api\\'
], function () {

    Route::name('user::')->prefix('user')->group(function () {
        Route::get('/', 'UserController@index');
        // Route::get('list', 'UserController@getAllUsers');
        // Route::get('show/{id}', 'UserController@show');
        // Route::get('delete/{id}', 'UserController@destroy');
        // Route::get('logout', 'UserController@logout');
        // Route::post('insert', 'UserController@store');
        // Route::put('update/{id}', 'UserController@update');
    });

});
