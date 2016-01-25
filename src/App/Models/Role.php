<?php namespace Crip\UserManager\App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package Crip\UserManager\App\Models
 */
class Role extends Model
{
    public function users()
    {
        // TODO: move user class name to configuration file
        return $this->belongsToMany(User::class);
    }

    public function perms()
    {
        return $this->belongsToMany(Perm::class);
    }
}