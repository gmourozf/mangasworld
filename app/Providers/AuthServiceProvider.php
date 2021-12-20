<?php

namespace App\Providers;

use App\Models\Manga;
use App\Policies\MangaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
         Manga::class => MangaPolicy::class,
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
        Gate::define('contrib', function($user){
            return $user->role == 'contrib';
        });

        //verifier que l'utilisateur  dispose du role Commentateur
        Gate::define('comment', function($user){
            return $user->role == 'comment';
        });
    }
}
