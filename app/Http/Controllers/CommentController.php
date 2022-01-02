<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Models\Manga;
use Request;
use Exception;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;




class CommentController extends Controller
{



    /**
     * cette fonction renvoie la liste de tous les commentaires associés
     * a un manga
     */
    public function getComments($id_manga)
    {
        $user = Auth::user();
        $erreur = Session::get('erreur');
        $readonly = null;
        Session::forget('erreur');

        $manga = Manga::find($id_manga);
        $titreVue = $manga->titre;
        $commentaires = Commentaire::where('id_manga', $id_manga)->get();
        return view('listeCommentaires', compact('user', 'manga', 'commentaires', 'erreur', 'readonly', 'titreVue'));
    }

    public function addComment($id_manga)
    {
        $user = Auth::user();
        $erreur = Session::get('erreur');
        $readonly = null;
        Session::forget('erreur');
        $titreVue = "Ajouter un commentaire";
        $commentaire = new Commentaire();
        $manga = Manga::find($id_manga);

        //on vérifie que l'utilisateur a bien le droit d'ajouter un commentaire

        if (!$user->can('comment', $manga)) {
            $erreur = "Vous ne pouvez que consulter les commentaires !";
            $readonly = 'readonly';
        }
        return view('formCommentaire', compact('manga', 'commentaire', 'user', 'titreVue', 'readonly', 'erreur'));
    }

    public function showComment($id_comment)
    {
    }
    public function validateComment($id)
    {
    }
}
