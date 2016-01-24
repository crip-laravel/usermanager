<?php namespace Tahq69\ScriptUserManager\Script\Traits;

use Tahq69\ScriptUserManager\Script\Models\Role;

/**
 * Class UserManagerUser
 * @package Tahq69\ScriptUserManager\Script\Traits
 */
trait UserManagerUser
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}