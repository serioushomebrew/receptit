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

Route::get('/test', function () {
    /*$url = 'https:\/\/frahmework.ah.nl\/ah\/json\/producten?recepttags=banaan|halfvollemelk|jesaromabanaan|bananenschuimpjes|spuitbusslagroom|minim&m&weergaveprionr=1';

    $urlSplit = explode('?', $url);
    if(count($queryString) > 1) {
        $url = $urlSplit[0] . '?';


    }

    dd(($url));*/

/*
    $tmp = explode('?', $url);

    for($i = 0, $isValue = false; $i < strlen($url); $i++) {
        if()



        if($isValue === false && $url[$i] === '=') {

        }


        if($foundAmp === false && ($url[$i] === '?' || $url[$i] === '&')) {
            $foundAmp = true;
            $new .= $url[$i];
        } else ($url[$i] === '?' || $url[$i] === '&') {

        }
    }*/


    /*for($i = 0, $isValue = false; $i < strlen($url); $i++) {
        if(($url[$i] === '?' || $url[$i] === '&') && $isValue == true) {
            $new .= urlencode($url[$i]);
        } else if($url[$i] === '?' || $url[$i] === '&') {
            $new .= $url[$i];
            $new .= '---';
        } else {
            $new .= $url[$i];
            $isValue = true;
        }
    }*/

    // dd($new);
});

Route::group(['namespace' => 'Api', 'prefix' => 'api', 'as' => 'api::', 'middleware' => []], function () {
    Route::post('/search/product-tags', [
        'uses' => 'SearchController@postLiveSearchProductTags',
        'as' => 'search::product-tags',
    ]);

    Route::post('/search/recipes', [
        'uses' => 'SearchController@postSearchRecipes',
        'as' => 'search::recipes',
    ]);
});

Route::resource('/scan', 'BonusClientController');
