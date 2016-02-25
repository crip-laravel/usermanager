<?php namespace Crip\UserManager\App\Models;

use Crip\Core\Data\Repository;

/**
 * Class PermRepository
 * @package Crip\UserManager\App\Models
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
        return Perm::class;
    }

    /**
     * Allowed repo relations array
     *
     * @return array
     */
    public function relations()
    {
        return [
            'perms',
            'perms.users'
        ];
    }
}