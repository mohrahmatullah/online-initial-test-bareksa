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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'PostController@index')->name('/');
Route::get('news/{id}', 'PostController@newsUpdate')->name('news-update');
Route::get('tag', 'PostController@tag')->name('tag');
Route::get('tag/{id}', 'PostController@tagUpdate')->name('tag-update');
Route::get('topik', 'PostController@topik')->name('topik');
Route::get('topik/{id}', 'PostController@topikUpdate')->name('topik-update');

Route::post('news/{id}', 'PostController@saveNews')->name('save-news');
Route::post('tag/{id}', 'PostController@saveTag')->name('tag-save');
Route::post('topik/{id}', 'PostController@saveTopik')->name('topik-save');
Route::get('/ajax/delete-item', 'PostController@deletedAjax')->name('deleted-ajax');