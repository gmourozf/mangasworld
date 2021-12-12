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

use App\Http\Controllers\MangaController;

Route::get('/','HomeController@index' );
Route::get('/listerMangas', 'MangaController@getMangas');

//lister tous les mangas d'un genre séléctionné
Route::post('/listerMangasGenre', 'MangaController@getMangasGenre');

Route::get('/listerGenres', 'GenreController@getGenres');

//aficher un manga pour pouvoir eventuellement le modifier
Route::get('/modifierManga/{id}', 'MangaController@updateManga');

Route::post('/validerManga', 'MangaController@validateManga');

Route::get('/ajouterManga', 'MangaController@addManga');

Route::get('/supprimerManga/{id}', 'MangaController@deleteManga');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profil','ProfilController@getProfil');

Route::post('/profil','ProfilController@setProfil');
