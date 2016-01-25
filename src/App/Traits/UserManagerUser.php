<?php namespace Crip\Usermanager\App\Traits;

use Crip\Usermanager\App\Models\Role;

/**
 * Class UserManagerUser
 * @package Crip\UserManager\App\Traits
 */
trait UserManagerUser
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}