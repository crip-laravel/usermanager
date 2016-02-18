<?php namespace Crip\UserManager\App\Repositories;

use Crip\Core\Data\Repository;
use Crip\UserManager\App\UserManager;

/**
 * Class UserRepository
 * @package Crip\UserManager\App\Repositories
 */
class UserRepository extends Repository
{

    /**
     * Retrieve model name
     *
     * @return string
     */
    public function model()
    {
        return UserManager::package()->config('user');
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
            'roles.perms'
        ];
    }
}