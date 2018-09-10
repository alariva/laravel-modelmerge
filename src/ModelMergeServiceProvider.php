<?php

namespace Alariva\ModelMerge;

use Illuminate\Support\ServiceProvider;

class ModelMergeServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/modelmerge.php' => config_path('modelmerge.php'),
            ], 'modelmerge.config');

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/modelmerge.php', 'modelmerge');

        // Register the service the package provides.
        $this->app->singleton('modelmerge', function ($app) {
            return new ModelMerge;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modelmerge'];
    }
}