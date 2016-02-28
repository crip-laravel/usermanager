<?php namespace Crip\UserManager\Services;

use Crip\Core\Contracts\ICripObject;
use Crip\Core\Helpers\Str;
use Crip\UserManager\App\UserManager;
use Crip\UserManager\Contracts\IHasRole;
use Crip\UserManager\Repositories\PermRepository;

/**
 * Class UserModelService
 * @package Crip\UserManager\Services
 */
class UserModelService implements ICripObject
{

    /**
     * @var PermRepository
     */
    private $permRepository;

    /**
     * Property for caching permissions.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $permissions;

    /**
     * Property for caching permissions unique id.
     *
     * @var int
     */
    protected $user_id;

    /**
     * @param PermRepository $permRepository
     */
    public function __construct(PermRepository $permRepository)
    {
        $this->permRepository = $permRepository;
    }

    /**
     * Check if pretend option is enabled.
     *
     * @return bool
     */
    private function isPretendEnabled()
    {
        return (bool)UserManager::package()->config('pretend.enabled');
    }

    /**
     * Allows to pretend or simulate package behavior.
     *
     * @param string $option
     * @return bool
     */
    private function pretend($option)
    {
        return (bool)UserManager::package()->config('pretend.options.' . $option);
    }

    /**
     *  Check if the user has at least one role.
     *
     * @param int|string $role
     * @param IHasRole $model
     *
     * @return bool
     */
    public function hasCripRole($role, IHasRole $model)
    {
        foreach (Str::toArray($role) as $role) {
            if ($model->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all roles.
     *
     * @param int|string $role
     * @param IHasRole $model
     *
     * @return bool
     */
    public function hasAllCripRoles($role, IHasRole $model)
    {
        foreach (Str::toArray($role) as $role) {
            if (!$model->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user has a role or roles.
     *
     * @param int|string|array $role
     * @param IHasRole $model
     * @param bool $all
     *
     * @return bool
     */
    public function is($role, IHasRole $model, $all = false)
    {
        if ($this->isPretendEnabled()) {
            return $this->pretend('is');
        }

        return $all ?
            $this->hasAllCripRoles($role, $model) :
            $this->hasCripRole($role, $model);
    }

    /**
     * @param IHasRole $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function permissions(IHasRole $model)
    {
        if ($model->id !== $this->user_id || !$this->permissions) {
            $this->user_id = $model->id;

            // get all permissions for user roles
            $results = $this->permRepository->getForUserRoles($model);
            // merge user specific roles with role permissions
            $this->permissions = $model->userPermissions()->get()->merge($results);
        }

        return $this->permissions;
    }

    /**
     * Check if the user has a permission or permissions.
     *
     * @param int|string|array $permission
     * @param IHasRole $model
     * @param bool $all
     *
     * @return bool
     */
    public function can($permission, IHasRole $model, $all = false)
    {
        if ($this->isPretendEnabled()) {
            return $this->pretend('can');
        }

        return $all ?
            $this->hasAllCripPermissions($permission, $model) :
            $this->hasCripPermission($permission, $model);
    }

    /**
     * @param int|string|array $permission
     * @param IHasRole $model
     *
     * @return bool
     */
    private function hasCripPermission($permission, IHasRole $model)
    {
        foreach (Str::toArray($permission) as $role) {
            if ($model->hasPermission($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int|string|array $permission
     * @param IHasRole $model
     *
     * @return bool
     */
    private function hasAllCripPermissions($permission, IHasRole $model)
    {
        foreach (Str::toArray($permission) as $role) {
            if (!$model->hasPermission($role)) {
                return false;
            }
        }

        return true;
    }
}