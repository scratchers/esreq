<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\{Esrequest,FacultyAccount};
use App\Policies\{EsrequestPolicy,FacultyAccountPolicy};
use App\Institution;
use App\Policies\InstitutionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Esrequest::class => EsrequestPolicy::class,
        FacultyAccount::class => FacultyAccountPolicy::class,
        Institution::class => InstitutionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            if ( $user->isAdmin() ) {
                return true;
            }
        });
    }
}
