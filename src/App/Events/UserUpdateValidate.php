<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Data\Model;
use Illuminate\Http\Request;

/**
 * Class UserUpdateValidate
 * @package Crip\UserManager\App\Events
 */
class UserUpdateValidate
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var array
     */
    public $input;

    /**
     * @var \App\User
     */
    public $instance;

    /**
     * @param int $id
     * @param Request $request
     * @param Model $instance
     */
    public function __construct($id, Request $request, Model $instance)
    {
        $this->id = $id;
        $this->request = $request;
        $this->input = $request->all();
        $this->instance = $instance;
    }
}