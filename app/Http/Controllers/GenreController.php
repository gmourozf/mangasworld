<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use Session;

class GenreController extends Controller
{
    //

    /* afficher les genres dans une liste déroulante
    @return vue formGenre
     */

    public function getGenres()
    {
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $genres = Genre::all();
        return view('formGenre', compact('genres', 'erreur'));
    }
}
