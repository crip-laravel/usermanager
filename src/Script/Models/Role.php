<?php namespace Tahq69\ScriptUserManager\Script\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package Tahq69\ScriptUserManager\Script\Models
 */
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function perms()
    {
        return $this->belongsToMany(Perm::class);
    }
}