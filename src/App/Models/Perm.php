<?php namespace Crip\UserManager\App\Models;

use Crip\Core\Contracts\ICripObject;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Perm
 * @package Crip\UserManager\App\Models
 */
class Perm extends Model implements ICripObject
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}