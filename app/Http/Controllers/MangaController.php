<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Manga;
use Request;

class MangaController extends Controller
{
    //
    public function getMangas()
    {
        //on recupère la liste de tous les mangas
        $mangas = Manga::all();
        /*  on appelle la vue listeMangas à laquelle on passe en paramètre la variable $mangas, mais sans le $ et préalablement insérée dans un tableau via la fonction PHP compact().
On remarquera que l'on a mis au pluriel la variable $mangas car elle représente une collection. */

        return view('listeMangas', compact('mangas'));
    }

    /**
     * Afficher la liste de tous les mamnga d'unn genre
     * si on selectionné un genre on récupère la liste de tous les mangas de
     * ce genre et on les affiche
     * si on n'a pas selectionner de genre on affiche un message d'erreur et
     * on relance le formulaire de selection d'un genre on le passant le message
     * @return vue listerMangas
     */

    public function getMangasGenre()
    {
        $erreur = "";
        // on recupère l'id du genre selectionné
        $id_genre = Request::input('cbGenre');
        // si on a un id de genre
        if ($id_genre) {

            $mangas = Manga::where('id_genre', $id_genre)->get();
            return view('/listeMangas', compact('mangas', 'erreur'));

            //on recupère la liste de tous les mangas du genre choisi
        } else {
            $erreur = "il faut selectionner un genre";
            return redirect('/listerGenres/' . $erreur);
        }

        return view('listeMangas', compact('mangas'));
    }
}
