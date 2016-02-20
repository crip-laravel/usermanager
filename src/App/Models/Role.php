<?php namespace Crip\UserManager\App\Models;

use Crip\Core\Data\Model;

/**
 * Class Role
 * @package Crip\UserManager\App\Models
 */
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(UserManager::package()->config('name'));
    }

    public function perms()
    {
        return $this->belongsToMany(Perm::class);
    }
}