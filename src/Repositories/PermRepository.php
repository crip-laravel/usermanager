<?php namespace Crip\UserManager\Repositories;

use Crip\Core\Data\Repository;
use Crip\UserManager\App\UserManager;
use Crip\UserManager\IHasRole\IHasRole;

/**
 * Class PermRepository
 * @package Crip\UserManager\Repositories
 */
class PermRepository extends Repository
{

    /**
     * Retrieve model name
     *
     * @return string
     */
    public function model()
    {
        return UserManager::package()->config('models.permission');
    }

    /**
     * Allowed repo relations array
     *
     * @return array
     */
    public function relations()
    {
        return [
            'roles',
            'roles.users'
        ];
    }

    /**
     * @param IHasRole $model
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getForUserRoles(IHasRole $model)
    {
        return $this->modelInstance->select([
            'permissions.*',
            'permission_role.created_at as pivot_created_at',
            'permission_role.updated_at as pivot_updated_at'
        ])
            ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
            ->join('roles', 'roles.id', '=', 'permission_role.role_id')
            ->whereIn('roles.id', $model->getRoles()->lists('id')->toArray())
            ->groupBy(['permissions.id', 'pivot_created_at', 'pivot_updated_at']);
    }
}