<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Models\Manga;
use Error;
use Request;
use Exception;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
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
    /**
     * Formulaire d'ajout de commentaire sur
     * un manga par un lecteur.
     */
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
            $erreur = "Vous ne pouvez que consulter les commentaires mais pas en ajouter !";
            $readonly = 'readonly';
        }
        return view('formCommentaire', compact('manga', 'commentaire', 'user', 'titreVue', 'readonly', 'erreur'));
    }

    public function showComment($id_comment)
    {
        $commentaire = Commentaire::find($id_commentaire);
        $id_manga = $commentaire->manga->id_manga;
        $manga = Manga::find($id_manga);
        $erreur = Session::get('erreur');
        //on supprime le message d'erreur stocké dans la session
        Session::forget('erreur');
        $readonly = 'readonly';
        $titreVue = "Modification d'un commentaire";
        //on vérifie que l'utilisateur a bien le droit de modifier
        $user = Auth::user();

        //  if (!$user->can('viewComments',$commentaire)) {
        //      $erreur = "Vous ne pouvez que consulter les commentaires mais pas en le modifier  !";
        //      $readonly = 'readonly';
        //  }
        //afficher le formulaire en lui donnant les données à afficher
        return view('formCommentaire', compact('manga', 'commentaire', 'user', 'titreVue', 'readonly', 'erreur'));
    }

    public function validateComment()
    {  // on recupère le commentaire  posté
        $user = Auth::user();
        $id_manga = Request::input('id_manga');
        $id_commentaire = Request::input('id_commentaire');
        $lib_commentaire = Request::input('lib_commentaire');

        // on enonce les règles de validations
        // on met la liste des champs a valider dans un array

        $regles = array(
            'lib_commentaire' => 'required',
        );

        $messages = array(
            'lib_commentaire.required'=> 'Il faut saisir un commentaire',
        );
        //Validation du champs de commentaire et on applique les règles de vérification
        $validator = Validator::make(Request::all(), $regles, $messages);
        //on retourne au formulaire s'il y a un problème.
        if ($validator->fails()) {

        // si le libellé est vide on retoure sur la saisie du commentaire
            if ($id_commentaire > 0) {
                return redirect('modifierCommentaire/'. $id_manga)
                    ->withErrors($validator)
                    ->withInput();
            } else {
                return redirect('ajouterCommentaire/' . $id_manga)
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        //s'il y a déjà un commentaire alors on va le chercher en base sinon on crée l'objet
        if ($id_commentaire > 0) {
            $commentaire = Commentaire::find($id_commentaire);
        } else {
            $commentaire = new Commentaire();
        }

        //on créé / modifie un commentaire.
        $commentaire->lib_commentaire = $lib_commentaire;
        // si on est en création d'un commentaire alors on rempli les champs id_manga, id_lecteur
        if (!$id_commentaire > 0) {
            $commentaire->id_manga = $id_manga;
            $commentaire->id_lecteur = $user->id;
        }

        try {
            $commentaire->save();
            return redirect('/listerCommentaires/'. $id_manga);
        } catch (Exception $ex) {
            $erreur = $ex->getMessage();
            Session::put('erreur', $erreur);
            return redirect('/listerCommentaires/'. $id_manga);
        }
    }

    public function updateComment($id_commentaire)
    {
        $commentaire = Commentaire::find($id_commentaire);
        $id_manga = $commentaire->manga->id_manga;
        $manga = Manga::find($id_manga);
        $erreur = Session::get('erreur');
        //on supprime le message d'erreur stocké dans la session
        Session::forget('erreur');
        $readonly = null;
        $titreVue = "Modification d'un commentaire";
        //on vérifie que l'utilisateur a bien le droit de modifier
        $user = Auth::user();

        if (!$user->can('comment', $commentaire)) {
            $erreur = "Vous ne pouvez que consulter les commentaires mais pas en le modifier  !";
            $readonly = 'readonly';
        }
        //afficher le formulaire en lui donnant les données à afficher
        return view('formCommentaire', compact('manga', 'commentaire', 'user', 'titreVue', 'readonly', 'erreur'));
    }


    /***fonction qui permet de supprimer un commentaire dont on est l'auteur. */


    public function deleteComment($id_commentaire)
    {
        $erreur = Session::get('erreur');
        Session::forget('erreur');
        $commentaire = Commentaire::find($id_commentaire);
        $id_manga = $commentaire->manga->id_manga;
        $user = Auth::user();
        if(($user->can('supprimerCommentaire', $commentaire)) ==false)
        //if (($user->role == 'comment' && $user->id == $commentaire->id_lecteur) == false)
            {
            $erreur = "vos droits sont insuffisants pour supprimer ce commentaire";
            Session::put('erreur', $erreur);
            return redirect('/listerCommentaires/'. $id_manga);

        }
            try {
                $commentaire->delete();
            } catch (Exception $ex) {
                $erreur = $ex->getMessage();
                Session::put('erreur', $erreur);
                return redirect('/listerCommentaires/'. $id_manga);
            }

            return redirect('/listerCommentaires/'. $id_manga);
        }
    }

