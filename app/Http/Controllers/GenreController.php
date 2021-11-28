<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    //

    /* afficher les genres dans une liste déroulante
    @return vue formGenre
     */

    public function getGenres($erreur = "")
    {
        $genres = Genre::all();
        return view('formGenre', compact('genres', 'erreur'));
    }
}
