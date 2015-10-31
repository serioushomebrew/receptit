<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Api', 'prefix' => 'api', 'as' => 'api::', 'middleware' => []], function () {
    Route::post('/search/product-tags', [
        'uses' => 'SearchController@postLiveSearchProductTags',
        'as' => 'search::product-tags',
    ]);

    Route::post('/search', [
        'uses' => 'SearchController@postSearch',
        'as' => 'search',
    ]);
});
