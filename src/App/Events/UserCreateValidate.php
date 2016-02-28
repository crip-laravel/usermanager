<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Events\CripEvent;
use Illuminate\Http\Request;

/**
 * Class UserCreateValidate
 * @package Crip\UserManager\App\Events
 */
class UserCreateValidate extends CripEvent
{

    /**
     * @var Request
     */
    public $request;

    /**
     * @var array
     */
    public $input;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->input = $request->all();
    }

}