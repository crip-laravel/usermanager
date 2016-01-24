<?php namespace Tahq69\ScriptUserManager;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Tahq69\ScriptUserManager\Script\Package;
use Tahq69\ScriptUserManager\Script\UserManager;

/**
 * Class ScriptUserManagerServiceProvider
 * @package Tahq69\ScriptUserManager
 */
class ScriptUserManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // init package translations
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', Package::NAME);
        // init package views
        $this->loadViewsFrom(__DIR__ . '/resources/views', Package::NAME);

        // init router (should be initialised after loadViewsFrom if is using views)
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Script/Routes.php';
        }

        // This will allow users of your package to easily override your default configuration options after publishing
        // php artisan vendor:publish --provider="Tahq69\ScriptUserManager\ScriptUserManagerServiceProvider"
        $this->publishes([
            __DIR__ . '/public' => Package::public_path(),
            __DIR__ . '/resources/views' => base_path('resources/views/vendor/' . Package::NAME),
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ]);

        // php artisan vendor:publish --provider="Tahq69\ScriptUserManager\ScriptUserManagerServiceProvider" --tag=config
        $this->publishes([
            __DIR__ . '/config/' . Package::NAME . '.php' => config_path(Package::NAME . '.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // merge package configuration file with the application's copy.
        $this->mergeConfigFrom(
            __DIR__ . '/config/' . Package::NAME . '.php', Package::NAME
        );

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('UserManager', UserManager::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(Package::NAME);
    }
}