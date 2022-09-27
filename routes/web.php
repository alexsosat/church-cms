<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

    Route::group(['prefix' => 'churches', 'as' => 'churches.', 'namespace' => 'App\Http\Controllers'], function () {
        Route::get('/', [App\Http\Controllers\ChurchController::class, 'index']);
        Route::get('/create', ['as' => 'create', 'uses' => 'ChurchController@create']);

        Route::prefix('/{user:id}')->group(function () {
            Route::get('/edit', ['as' => 'edit', 'uses' => 'ChurchController@edit']);


            Route::patch('/update_info', ['as' => 'updateInfo', 'uses' => 'ChurchController@updateInfo']);
            Route::patch('/update_credentials', ['as' => 'updateCredentials', 'uses' => 'ChurchController@updateCredentials']);
            Route::patch('/update_geo', ['as' => 'updateGeo', 'uses' => 'ChurchController@updateGeo']);


        });

        Route::post('/store', ['as' => 'store', 'uses' => 'ChurchController@store']);

        Route::delete('/delete', ['as' => 'delete', 'uses' => 'ChurchController@destroy']);

    });

    Route::group(['prefix' => 'members', 'as' => 'members.', 'namespace' => 'App\Http\Controllers'], function () {
        Route::get('/', [App\Http\Controllers\MemberController::class, 'index']);
        Route::get('/create', ['as' => 'create', 'uses' => 'MemberController@create']);

        Route::prefix('/{member:id}')->group(function () {
            Route::get('/show', ['as' => 'show', 'uses' => 'MemberController@show']);
            Route::get('/edit', ['as' => 'edit', 'uses' => 'MemberController@edit']);

            Route::patch('/update', ['as' => 'update', 'uses' => 'MemberController@update']);


        });

        Route::post('/store', ['as' => 'store', 'uses' => 'MemberController@store']);

    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'App\Http\Controllers'], function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'show']);

        Route::patch('/update_info', ['as' => 'update_info', 'uses' => 'ProfileController@updateInfo']);
        Route::patch('/update_password', ['as' => 'update_password', 'uses' => 'ProfileController@updatePsswd']);
        Route::patch('/update_credentials', ['as' => 'update_credentials', 'uses' => 'ProfileController@updateCredentials']);
        Route::patch('/update_geo', ['as' => 'update_geo', 'uses' => 'ProfileController@updateGeo']);

    });


});


