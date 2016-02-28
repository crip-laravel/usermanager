<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Events\CripEvent;
use Illuminate\Http\Request;

/**
 * Class UserCreate
 * @package Crip\UserManager\App\Events
 */
class UserCreate extends CripEvent
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var \App\User
     */
    private $auth_user;

    public function __construct(Request $request, $auth_user)
    {
        $this->request = $request;
        $this->auth_user = $auth_user;
    }
}