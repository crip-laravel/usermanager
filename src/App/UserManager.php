<?php namespace Crip\UserManager\App;

use Crip\Core\Support\PackageBase;
use Crip\UserManager\App\Services\SocialiteService;

/**
 * Class UserManager
 * @package Crip\UserManager\App
 */
class UserManager
{
    /**
     * @var PackageBase
     */
    private static $package;

    /**
     * @return PackageBase
     */
    public static function package()
    {
        if (!self::$package) {
            self::$package = new PackageBase('cripusermanager', __DIR__ . '/..');
        }

        return self::$package;
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return mixed
     * @throws BadConfigurationException
     */
    public function redirectToSocialProvider($provider)
    {
        return app(SocialiteService::class)->redirect($provider);
    }

    /**
     * Handle social provider callback action for authorisation
     *
     * @param $provider
     */
    public function handleSocialProviderCallback($provider)
    {
        app(SocialiteService::class)->handle($provider);
    }
}