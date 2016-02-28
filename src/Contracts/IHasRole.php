<?php namespace Crip\UserManager\Contracts;

/**
 * Interface IHasRole
 * @package Crip\UserManager\IHasRole
 */
interface IHasRole
{

    /**
     * User belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * Get all roles as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles();

    /**
     * Check if the user has role.
     *
     * @param int|string $role
     *
     * @return bool
     */
    public function hasRole($role);

    /**
     * Attach role to user
     *
     * @param int|\Crip\UserManager\Models\Role $role
     */
    public function attachRole($role);

    /**
     * Detach role from user
     *
     * @param int|\Crip\UserManager\Models\Role $role
     */
    public function detachRole($role);

    /**
     * Check if the user has a role or roles.
     *
     * @param int|string|array $role
     * @param bool $all
     * @return bool
     */
    public function is($role, $all = false);

    /**
     * User belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userPermissions();

    /**
     * Get all permissions as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function permissions();

    /**
     * Check if the user has a permission.
     *
     * @param int|string|array $permission
     * @param bool $all
     * @return bool
     */
    public function can($permission, $all = false);

    /**
     * Check if the user has permission.
     *
     * @param int|string $permission
     *
     * @return bool
     */
    public function hasPermission($permission);
}