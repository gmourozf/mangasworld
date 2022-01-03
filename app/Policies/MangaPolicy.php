<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Manga;

class MangaPolicy
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

    //seul les contributeurs qui ont créé le Manga peuvent le modifier
    public function modifier(User $user, Manga $manga)
    {   
        $autorized = ($user->role == 'contrib' && $user->id == $manga->id_lecteur);
        return $autorized;
    }
    // seul les contributeurs qui ont créé le Manga peuvent le supprimer
    public function supprimer(User $user, Manga $manga)
    {
        $autorized = ($user->role == 'contrib' && $user->id == $manga->id_lecteur);
        return $autorized;
    }
}
