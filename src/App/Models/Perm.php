<?php namespace Crip\UserManager\App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Perm
 * @package Crip\UserManager\App\Models
 */
class Perm extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
        // "Tahq69\ScriptUserManager\Script\Models\Role"
    }
}