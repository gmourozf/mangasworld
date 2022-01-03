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

//les routes d'authentification (se connecter s'inscrire ..)
Auth::routes();
//les routes publiques
//page d'accueil
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

//afficher la liste de tous les Mangas.
Route::get('/listerMangas', 'MangaController@getMangas');

//lister tous les mangas d'un genre séléctionné
Route::post('/listerMangasGenre', 'MangaController@getMangasGenre');

//Afficher la liste déroulante des genres
Route::get('/listerGenres', 'GenreController@getGenres');


//Les routes protégées
Route::group(['middleware' => ['auth']], function () {
    //Afficher le Profil
    Route::get('/profil', 'ProfilController@getProfil');
    //Enregistrer la mise  à  jour du profil
    Route::post('/profil', 'ProfilController@setProfil');
    //Demande d'a jout d'un Manga
    Route::get('/ajouterManga', 'MangaController@addManga')->middleware('can:contrib'); //autorise l'accès seulement si l'utilisateur a le rôle can contrib
    // demande de consultation d'un Manga
    Route::get('/consulterManga/{id}', 'MangaController@showManga')->middleware('can:comment');
    Route::get('/modifierManga/{id}', 'MangaController@updateManga')->middleware('can:contrib');

    Route::post('/validerManga', 'MangaController@validateManga');

    Route::get('/supprimerManga/{id}', 'MangaController@deleteManga');
});

// Route::get('/listerCommentaires/{id}', 'CommentController@getComments')->middleware('can:comment');
Route::get('/listerCommentaires/{id}', 'CommentController@getComments');

Route::get('/ajouterCommentaire/{id}', 'CommentController@addComment')->middleware('can:comment');

//les commentaires créés sont enregistrés en base
Route::post('/validerCommentaire', 'CommentController@validateComment')->middleware('can:comment');
Route::get('/modifierCommentaire/{id}', 'Commentcontroller@updateComment')->middleware('can:comment');
Route::get('/consulterCommentaire/{id}', 'CommentController@showComment')->middleware('can:viewComments');
Route::get('/supprimerCommentaire/{id}', 'CommentController@deleteComment');


