<?php namespace Crip\UserManager\Contracts;

/**
 * Interface IHasPerm
 * @package Crip\UserManager\IHasRole
 */
interface IHasPerm
{
    /**
     * Role belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms();

    /**
     * Attach permission to role
     *
     * @param int|\Crip\UserManager\Models\Perm $perm
     */
    public function attachPerm($perm);

    /**
     * Detach permission from role
     *
     * @param int|\Crip\UserManager\Models\Perm $perm
     */
    public function detachPerm($perm);
}