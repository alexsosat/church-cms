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

    Route::middleware('can:is-admin')->group(function () {
        Route::group(['prefix' => 'churches', 'as' => 'churches.', 'namespace' => 'App\Http\Controllers'], function () {
            Route::get('/', [App\Http\Controllers\ChurchController::class, 'index']);
            Route::get('/create', ['as' => 'create', 'uses' => 'ChurchController@create']);

            Route::prefix('/{user:id}')->group(function () {
                Route::get('/edit', ['as' => 'edit', 'uses' => 'ChurchController@edit']);


                Route::patch('/update-info', ['as' => 'updateInfo', 'uses' => 'ChurchController@updateInfo']);
                Route::patch('/update-credentials', ['as' => 'updateCredentials', 'uses' => 'ChurchController@updateCredentials']);
                Route::patch('/update-geo', ['as' => 'updateGeo', 'uses' => 'ChurchController@updateGeo']);


            });

            Route::post('/store', ['as' => 'store', 'uses' => 'ChurchController@store']);

            Route::delete('/delete', ['as' => 'delete', 'uses' => 'ChurchController@destroy']);

        });
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

    Route::group(['prefix' => 'requests', 'as' => 'requests.', 'namespace' => 'App\Http\Controllers'], function () {
        Route::get('/', [App\Http\Controllers\RequestController::class, 'index']);
        Route::get('/create-sending-request', ['as' => 'create-sending-request', 'uses' => 'RequestController@createSendingRequest']);
        Route::get('/create-receiving-request', ['as' => 'create-receiving-request', 'uses' => 'RequestController@createReceivingRequest']);

        Route::patch('/single-request-action', ['as' => 'single-request-action', 'uses' => 'RequestController@singleRequestAction']);
        Route::patch('/multiple-request-action', ['as' => 'multiple-request-action', 'uses' => 'RequestController@multipleRequestAction']);
        Route::patch('/single-request-cancel', ['as' => 'single-request-cancel', 'uses' => 'RequestController@singleRequestCancel']);


        Route::post('/store-sending-request', ['as' => 'store-sending-request', 'uses' => 'RequestController@storeSendingRequest']);
        Route::post('/store-receiving-request', ['as' => 'store-receiving-request', 'uses' => 'RequestController@storeReceivingRequest']);

    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'App\Http\Controllers'], function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'show']);

        Route::patch('/update-info', ['as' => 'update_info', 'uses' => 'ProfileController@updateInfo']);
        Route::patch('/update-password', ['as' => 'update_password', 'uses' => 'ProfileController@updatePsswd']);
        Route::patch('/update-credentials', ['as' => 'update_credentials', 'uses' => 'ProfileController@updateCredentials']);
        Route::patch('/update-geo', ['as' => 'update_geo', 'uses' => 'ProfileController@updateGeo']);

    });


});



