<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //is-admin gate
        Gate::define('is-admin', function($user) {
            return $user->role() === 'admin';
        });

        //is-user gate
        Gate::define('is-user', function($user) {
            return $user->role() === 'user';
        });

        //verify that ticket belongs to user
        Gate::define('user-ticket', function($user, $ticket) {
            return $user->id == $ticket->user_id;
        });

    }
}
