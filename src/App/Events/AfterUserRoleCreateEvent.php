<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Events\CripEvent;

/**
 * Class AfterUserRoleCreateEvent
 * @package Crip\UserManager\App\Events
 */
class AfterUserRoleCreateEvent extends CripEvent
{
    /**
     * @var User
     */
    public $user;

    /**
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}