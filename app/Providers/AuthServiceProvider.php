<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::before(function (User $user) {
            if ($user->admin) {
                return true;
            }
        });

        foreach (['modify-enclosures', 'add-animals', 'edit-animals', 'archive-animals'] as $ability) {
            Gate::define($ability, function () {
                return false;
            });
        }
    }
}
