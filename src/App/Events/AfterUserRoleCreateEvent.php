<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Events\CripEvent;
use Crip\UserManager\App\Models\Role;

/**
 * Class AfterUserRoleCreateEvent
 * @package Crip\UserManager\App\Events
 */
class AfterUserRoleCreateEvent extends CripEvent
{
    /**
     * @var Role
     */
    public $role;

    /**
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}