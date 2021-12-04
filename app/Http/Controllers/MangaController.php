<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Manga;
use App\Models\Genre;
use App\Models\Dessinateur;
use App\Models\Scenariste;
use Request;
use Exception;
use Session;


class MangaController extends Controller
{
    //
    public function getMangas()
    {
        //on recupère la liste de tous les mangas
        $mangas = Manga::all();
        /*  on appelle la vue listeMangas à laquelle on passe en paramètre la variable $mangas, mais sans le $ et préalablement insérée dans un tableau via la fonction PHP compact().
On remarquera que l'on a mis au pluriel la variable $mangas car elle représente une collection. */
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        return view('listeMangas', compact('mangas', 'erreur'));
    }

    /**
     * Afficher la liste de tous les manga d'un genre
     * si on selectionné un genre on récupère la liste de tous les mangas de
     * ce genre et on les affiche
     * si on n'a pas selectionner de genre on affiche un message d'erreur et
     * on relance le formulaire de selection d'un genre on le passant le message
     * @return vue listerMangas
     */

    public function getMangasGenre()
    {
        $erreur = Session::get('erreur');
        Session::forget('erreur');

        // on recupère l'id du genre selectionné après la validation du formulaire
        $id_genre = Request::input('cbGenre');
        // si on a un id de genre
        if ($id_genre) {
            $mangas = Manga::where('id_genre', $id_genre)->get();
            //on recupère la liste de tous les mangas du genre choisi
            return view('/listeMangas', compact('mangas', 'erreur'));
        } else {
            Session::put('erreur', 'il faut selectionner un genre');
            return redirect('/listerGenres');
        }

        // return view('listeMangas', compact('mangas'));
    }

    public function updateManga($id)
    {
        //on recupère le message d'erreur stocké dans la session
        $erreur = Session::get('erreur');
        //on supprime le message d'erreur stocké dans la session
        Session::forget('erreur');
        $manga = Manga::find($id);
        $genres = Genre::all();
        $dessinateurs = Dessinateur::all();
        $scenaristes = Scenariste::all();
        $titreVue = "Modification d'un manga";
        //afficher le formulaire en lui donnant les données à afficher
        return view('formManga', compact('manga', 'genres', 'dessinateurs', 'scenaristes', 'titreVue', 'erreur'));
    }

    public function validateManga()
    {
        //recuperation des valeurs saisies
        $id_manga = Request::input('id_manga');  // id dans le champs caché
        $id_dessinateur = Request::input('cbDessinateur'); //Liste déroulante
        $prix = Request::input('prix');
        $id_scenariste = Request::input('cbScenariste'); //liste déroulante
        $titre = Request::input('titre');
        $id_genre = Request::input('cbGenre'); // liste deroulante

        //si on upload une image il faut la sauvegarder
        //Sinon on récupère le nom dans le champ caché
        if (Request::hasFile('couverture')) {
            $image = Request::file('couverture');
            $couverture = $image->getClientOriginalName();
            Request::file('couverture')->move(base_path() . '/public/images/', $couverture);
        } else {
            $couverture = Request::input('couvertureHidden');
        }
        //si id_manga est >0 il faut lire le manga existant
        //sinon il faut creer le manga
        if ($id_manga > 0) {
            $manga = Manga::find($id_manga);
        } else {
            $manga = new Manga();
        }

        $manga->titre = $titre;
        $manga->couverture = $couverture;
        $manga->prix = $prix;
        $manga->id_dessinateur = $id_dessinateur;
        $manga->id_scenariste = $id_scenariste;
        $manga->id_genre = $id_genre;
        $manga->id_lecteur = 1;


        try {
            $manga->save();
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
            Session::put('erreur', $erreur);
            if ($id_manga > 0) {
                return redirect('/modifierManga/' . $id_manga);
            } else {
                return redirect('/ajouterManga');
            }
        }
        //on reaffiche la liste
        return redirect('/listerMangas');
    }
    /**
     * Formulair d'ajout d'un manga
     * initialise toutes les listes deroulantes
     * et place le formulaire Form manga en mode ajout
     * @param String $erreur message d'erreur (paramètre optionnel)
     * @return Vue formManga
     */
    public function addManga()
    {
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $manga = new Manga();
        $genres = Genre::all();
        $dessinateurs = Dessinateur::all();
        $scenaristes = Scenariste::all();
        $titreVue = "Ajout d'un Manga";
        //Afficher le formulaire en lui fournissant les données afficher
        return view('formManga', compact('manga', 'genres', 'dessinateurs', 'scenaristes', 'titreVue', 'erreur'));
    }

    public function deleteManga($id)
    {
        $manga = Manga::find($id);
        $erreur = "";

        try {
            $manga->delete();
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
            Session::put('erreur', $erreur);

            return redirect('/listerMangas');
        }

        return redirect('/listerMangas');
    }
}
