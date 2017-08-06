<?php

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

Route::get('/', 'ArticleController@index');

Route::get('articles/not-actioned', 'ArticleController@notActioned');
Route::get('articles/actioned', 'ArticleController@actioned');


Route::get('articles/collect', 'ArticleController@collect');
Route::post('articles/known/collect', 'ArticleController@storeKnownArticle');
Route::post('articles/collect', 'ArticleController@store');


Route::any('articles/confirm', 'ArticleController@confirm');

Route::put('articles/mark-actioned', 'ArticleController@markActioned');
Route::put('articles/unmark-actioned', 'ArticleController@unmarkActioned');
Route::delete('articles/delete', 'ArticleController@destroy');


Route::get('collections/history', 'ArticleController@collectionHistory');
Route::get('collections/{collection_id}/articles', 'ArticleController@articleCollection');




