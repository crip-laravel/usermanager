<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Events\CripEvent;

/**
 * Class AfterUserCreateEvent
 * @package Crip\UserManager\App\Events
 */
class AfterUserCreateEvent extends CripEvent
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