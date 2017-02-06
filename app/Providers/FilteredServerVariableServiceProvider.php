<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Exceptions\FilteredServerVariable;

class FilteredServerVariableServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FilteredServerVariable::class, function ($app) {
            return new FilteredServerVariable($app);
        });
    }
}
