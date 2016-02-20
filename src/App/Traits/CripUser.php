<?php namespace Crip\UserManager\App\Traits;

use Crip\UserManager\App\Models\Role;

/**
 * Class CripUser
 * @package Crip\UserManager\App\Traits
 */
trait CripUser
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Always crypt password when setting it to model
     *
     * @param $val
     */
    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = bcrypt($val);
    }
}