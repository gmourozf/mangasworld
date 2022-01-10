<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Commentaire;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function modifierCommentaire(User $user, Commentaire $commentaire)
    {
        $autorized = ($user->role == 'comment' &&  $user->id == $commentaire->id_lecteur);
        return $autorized;
    }
    // seul les contributeurs qui ont créé les commentaires  peuvent les supprimer
    public function supprimerCommentaire(User $user, Commentaire $commentaire)
    {
        $autorized = ($user->role == 'comment' && $user->id == $commentaire->id_lecteur);
        return $autorized;
    }
}
