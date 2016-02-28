<?php namespace Crip\UserManager\Traits;

use Crip\UserManager\App\UserManager;

/**
 * Class HasPerm
 * @package Crip\UserManager\Traits
 */
trait HasPerm
{

    /**
     * Role belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms()
    {
        return $this->belongsToMany(UserManager::package()->config('models.permission'))
            ->withTimestamps();
    }

    /**
     * Attach permission to role
     *
     * @param int|\Crip\UserManager\Models\Perm $perm
     */
    public function attachPerm($perm)
    {
        $this->perms()->attach($perm);
    }

    /**
     * Detach permission from role
     *
     * @param int|\Crip\UserManager\Models\Perm $perm
     */
    public function detachPerm($perm)
    {
        $this->perms()->detach($perm);
    }

}