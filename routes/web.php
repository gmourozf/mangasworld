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
    return view('home');
});
Route::get('/listerMangas', 'MangaController@getMangas');

//lister tous les mangas d'un genre séléctionné
Route::post('/listerMangasGenre', 'MangaController@getMangasGenre');

Route::get('/listerGenres/{erreur?}', 'GenreController@getGenres');

//aficher un manga pour pouvoir eventuellement le modifier
Route::get('/modifierManga/{id}/{erreur?}', 'MangaController@updateManga');

Route::post('/validerManga', 'MangaController@validateManga');

Route::get('/ajouterManga/{erreur?}', 'MangaController@addManga');
