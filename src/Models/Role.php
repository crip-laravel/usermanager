<?php namespace Crip\UserManager\Models;

use Crip\Core\Data\Model;
use Crip\UserManager\Traits\HasPerm;

/**
 * Class Role
 * @package Crip\UserManager\Models
 */
class Role extends Model
{

    use HasPerm;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.model'))
            ->withTimestamps();
    }

}