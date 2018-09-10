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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'alariva');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'alariva');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/modelmerge.php' => config_path('modelmerge.php'),
            ], 'modelmerge.config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/alariva'),
            ], 'modelmerge.views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/alariva'),
            ], 'modelmerge.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/alariva'),
            ], 'modelmerge.views');*/

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