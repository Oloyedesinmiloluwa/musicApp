<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/v1/users', 'UserController@store');
Route::post('/v1/playlists', 'PlayListController@store');
Route::post('/v1/tracks', 'TrackController@store');
Route::get('/v1/tracks', 'TrackController@index');
Route::put('/v1/tracks/{track}/favourite', 'TrackController@favouriteTrack');
Route::put('/v1/playlists/{playlist}/track/{track}', 'TrackController@addToPlaylist'); //Todo: validate params
Route::post('/v1/albums', 'AlbumController@store');
Route::put('/v1/albums/{album}/track/{track}', 'AlbumController@addTrack');
Route::post('/v1/genres/', 'GenreController@store');
Route::put('/v1/users/{user}/profile', 'UserController@updateProfile');
Route::get('/v1/user/favourites', 'UserController@getFavourites');
Route::put('/v1/tracks/{track}/rate', 'TrackController@rateAndComment');
Route::get('/v1/tracks/{track}/ratings', 'TrackController@getRatings');
