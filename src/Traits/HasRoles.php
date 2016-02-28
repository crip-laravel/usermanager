<?php namespace Crip\UserManager\Traits;

use Crip\UserManager\App\UserManager;
use Crip\UserManager\Services\UserModelService;
use Illuminate\Support\Str;

/**
 * Class HasRoles
 * @package Crip\UserManager\Traits
 */
trait HasRoles
{

    /**
     * Property for caching roles.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $roles;

    /**
     * Property for caching permissions.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $permissions;

    /**
     * User belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(UserManager::package()->config('models.role'));
    }

    /**
     * Get all roles as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles()
    {
        return (!$this->roles) ? $this->roles = $this->roles()->get() : $this->roles;
    }

    /**
     * Check if the user has role.
     *
     * @param int|string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->getRoles()->contains(function ($key, $value) use ($role) {
            return $role == $value->id || Str::is($role, $value->slug);
        });
    }

    /**
     * Attach role to user
     *
     * @param int|\Crip\UserManager\Models\Role $role
     */
    public function attachRole($role)
    {
        $this->roles()->attach($role);
    }

    /**
     * Detach role from user
     *
     * @param int|\Crip\UserManager\Models\Role $role
     */
    public function detachRole($role)
    {
        $this->roles()->detach($role);
    }

    /**
     * Check if the user has a role or roles.
     *
     * @param int|string|array $role
     * @param bool $all
     * @return bool
     */
    public function is($role, $all = false)
    {
        return app(UserModelService::class)->is($role, $this, $all);
    }

    /**
     * User belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userPermissions()
    {
        return $this->belongsToMany(UserManager::package()->config('models.permission'))
            ->withTimestamps();
    }

    /**
     * Get all permissions as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function permissions()
    {
        return app(UserModelService::class)->permissions($this);
    }

    /**
     * Check if the user has a permission.
     *
     * @param int|string|array $permission
     * @param bool $all
     * @return bool
     */
    public function can($permission, $all = false)
    {
        return app(UserModelService::class)->can($permission, $this, $all);
    }

    /**
     * Check if the user has permission.
     *
     * @param int|string $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->contains(function ($key, $value) use ($permission) {
            return $permission == $value->id || Str::is($permission, $value->slug);
        });
    }
}