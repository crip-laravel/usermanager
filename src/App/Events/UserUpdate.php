<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Data\Model;
use Crip\Core\Events\CripEvent;
use Illuminate\Http\Request;

/**
 * Class UserUpdate
 * @package Crip\UserManager\App\Events
 */
class UserUpdate extends CripEvent
{

    /**
     * @var Model
     */
    private $instance;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var \App\User
     */
    private $auth_user;

    /**
     * @param Model $instance
     * @param int $id
     * @param Request $request
     * @param $auth_user
     */
    public function __construct(Model $instance, $id, Request $request, $auth_user)
    {
        $this->instance = $instance;
        $this->id = $id;
        $this->request = $request;
        $this->auth_user = $auth_user;
    }
}