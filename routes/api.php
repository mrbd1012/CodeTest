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
Route::prefix('auth')->group(function (){
    Route::post('register', 'Api\AuthController@register');
    Route::post('login', 'Api\AuthController@login');
    Route::get('logout', 'Api\AuthController@logout')->middleware('auth:api');
    Route::get('user-profile', 'Api\AuthController@profile')->middleware('auth:api');
});
Route::middleware('auth:api')->prefix('user')->group(function(){
    //categories
    Route::get('/categories', 'Api\CategoryController@index');
    Route::post('/categories', 'Api\CategoryController@store');
    Route::put('/categories/{category}', 'Api\CategoryController@update');
    Route::delete('/categories/{category}', 'Api\CategoryController@destroy');
    Route::get('/categories/{category}/edit', 'Api\CategoryController@edit');

    //products
    Route::get('/products', 'Api\ProductController@index');
    Route::post('/products', 'Api\ProductController@store');
    Route::get('/products/{product}', 'Api\ProductController@show');
    Route::put('/products/{product}', 'Api\ProductController@update');
    Route::delete('/products/{product}', 'Api\ProductController@destroy');
    Route::get('/products/{product}/edit', 'Api\ProductController@edit');
});




