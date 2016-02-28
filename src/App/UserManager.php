<?php namespace Crip\UserManager\App;

use Crip\Core\Support\PackageBase;
use Crip\UserManager\Services\SocialiteService;

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
     * @var SocialiteService
     */
    private $socialite;

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
     * @return SocialiteService
     */
    private function socialite()
    {
        if ($this->socialite == null) {
            $this->socialite = app(SocialiteService::class);
        }

        return $this->socialite;
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
        return $this->socialite()->redirect($provider);
    }

    /**
     * Handle social provider callback action for authorisation
     *
     * @param $provider
     */
    public function handleSocialProviderCallback($provider)
    {
        $this->socialite()->handle($provider);
    }
}