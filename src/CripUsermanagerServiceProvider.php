<?php namespace Crip\UserManager;

use Crip\Core\Support\CripServiceProvider;
use Crip\Core\Support\PackageBase;
use Crip\UserManager\App\UserManager;
use Illuminate\Foundation\AliasLoader;

/**
 * Class CripUserManagerServiceProvider
 * @package Crip\UserManager
 */
class CripUserManagerServiceProvider extends CripServiceProvider
{
    private static $package;

    /**
     * php artisan vendor:publish --provider="Crip\UserManager\CripUserManagerServiceProvider"
     *
     * @return PackageBase
     */
    private static function package()
    {
        if (!self::$package) {
            self::$package = new PackageBase('cripusermanager', __DIR__);
            self::$package->publish_public = false;
            self::$package->enable_views = false;
        }

        return self::$package;
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->cripBoot(self::package());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->cripRegister(self::package());
    }

    /**
     * @param AliasLoader $loader
     */
    function aliasLoader(AliasLoader $loader)
    {
        $loader->alias('UserManager', UserManager::class);
    }
}