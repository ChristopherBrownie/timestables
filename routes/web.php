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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/leaderboard/{user?}', 'PagesController@showLeaderboard')->name('leaderboard');
Route::post('/leaderboard', 'PagesController@updateUser');
Route::post('/leaderboard/store', 'PagesController@storeUser');
