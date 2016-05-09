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

Route::get('players', 'GCLController@getPlayers');
Route::get('players/batters', 'GCLController@getBatters');
Route::get('players/pitchers', 'GCLController@getPitchers');

Route::get('pitches', 'GCLController@getPitches');
Route::get('plate_appearances', 'GCLController@getPlateAppearances');