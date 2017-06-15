<?php

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

Route::get('recipe/{id}', 'RecipeController@show')->middleware('api');

Route::get('recipe', 'RecipeController@list')->middleware('api');

Route::post('recipe', 'RecipeController@store')->middleware('api');

Route::put('recipe/{id}', 'RecipeController@store')->middleware('api');

Route::put('recipe/{id}/rate', 'RecipeController@rate')->middleware('api');
