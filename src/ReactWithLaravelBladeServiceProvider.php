<?php
namespace Ghazniali95\ReactWithLaravelBlade;

use Ghazniali95\ReactWithLaravelBlade\Console\CreateReactComponent;
use Illuminate\Support\ServiceProvider;

class ReactWithLaravelBladeServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind any interfaces to implementations
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateReactComponent::class,
            ]);
        }
    }
}
