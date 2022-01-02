<?php

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Auth;
use App\Models\Manga;
use App\Policies\CommentPolicy;
use App\Policies\MangaPolicy;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // Ajout de la politique de sécurité sur le modèle
        // App\Models\Manga à la collection des politiques de sécurité
        // pour que'elle soit prise en compte dans le code
        'App\Model' => 'App\Policies\ModelPolicy',
        Manga::class => MangaPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //verifie que l'utilisateur dispose du rôle Contributeur
        Gate::define('contrib', function ($user) {
            return $user->role == 'contrib';
        });

        //verifier que l'utilisateur  dispose du role Commentateur
        Gate::define('comment', function ($user) {
            return $user->role == 'comment';
        });
    }
}
