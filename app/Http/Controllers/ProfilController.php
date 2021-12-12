<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Lecteur;
use Illuminate\Support\Facades\Auth;
use Validator;
use Request;

class ProfilController extends Controller
{
    function getProfil()
    {
        $erreur = "";
        $user = Auth::user();
        $id_lecteur = $user->id;
        $lecteur = Lecteur::find($id_lecteur);
        return view('formProfil', compact('lecteur', 'user', 'erreur'));
    }
    function setProfil()
    { //message d'erreur personnalisés
        $messages = array(
            'nom.required' => 'Il faut saisir un nom.',
            'prenom.required' => 'Il faut sélectionner un prenom.',
            'cp.required' => 'Il faut saisir un code postal.',
            'cp.numeric' => 'Il faut saisir une valeur numérique.'
        );
        //liste des champs à verifier
        $regles = array(
            'nom' => 'required',
            'prenom' => 'required',
            'cp' => 'required | numeric'
        );
        $validator = Validator::make(Request::all(), $regles, $messages);
        //on retourne au formulaire s'il y a un problème;
        if ($validator->fail()) {
            return redirect('formProfil')
                ->withErrors($validator)
                ->withInput();
        }
        //on recupère les donnees et on enregistre
        $user = Auth::user();
        $id_lecteur  =  $user->id;
        $lecteur = Lecteur::find($id_lecteur);
        $lecteur->nom = Request::input('nom');
        $lecteur->prenom = Request::input('prenom');
        $lecteur->rue = Request::input('rue');
        $lecteur->cp = Request::input('cp');
        $lecteur->ville = Request::input('ville');
        $lecteur->save();
        return redirect('/home');
    }
}
