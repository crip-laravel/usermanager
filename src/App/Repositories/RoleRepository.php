<?php namespace Crip\UserManager\App\Repositories;

use Crip\Core\Data\Repository;
use Crip\UserManager\App\Models\Role;

/**
 * Class RoleRepository
 * @package Crip\UserManager\App\Repositories
 */
class RoleRepository extends Repository
{

    /**
     * Retrieve model name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * Allowed repo relations array
     *
     * @return array
     */
    public function relations()
    {
        return [
            'users',
            'perms'
        ];
    }
}