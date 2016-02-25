<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Data\Model;
use Illuminate\Http\Request;

/**
 * Class UserUpdateValidateEvent
 * @package Crip\UserManager\App\Events
 */
class UserUpdateValidateEvent
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
     * @var User
     */
    public $model;

    /**
     * @param int $id
     * @param Request $request
     * @param array $input
     * @param Model $instance
     */
    public function __construct($id, Request $request, array $input, Model $instance)
    {
        $this->id = $id;
        $this->request = $request;
        $this->input = $input;
        $this->model = $instance;
    }
}