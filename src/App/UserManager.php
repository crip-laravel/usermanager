<?php namespace Crip\UserManager\App;

use Crip\Core\Support\PackageBase;

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
}