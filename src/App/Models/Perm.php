<?php namespace Crip\UserManager\App\Models;

use Crip\Core\Data\Model;


/**
 * Class Perm
 * @package Crip\UserManager\App\Models
 */
class Perm extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}