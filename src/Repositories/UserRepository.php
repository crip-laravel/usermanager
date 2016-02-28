<?php namespace Crip\UserManager\Repositories;

use Crip\Core\Data\Repository;

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
        return config('auth.model');
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
            'roles.perms',
            'perms'
        ];
    }
}