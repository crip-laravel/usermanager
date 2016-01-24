<?php namespace Tahq69\ScriptUserManager\Script\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Perm
 * @package Tahq69\ScriptUserManager\Script\Models
 */
class Perm extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
        // "Tahq69\ScriptUserManager\Script\Models\Role"
    }
}