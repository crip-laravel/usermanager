<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Events\CripEvent;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

/**
 * Class UserRoleCreateValidateEvent
 * @package Crip\UserManager\App\Events
 */
class UserRoleCreateValidateEvent extends CripEvent
{

    /**
     * @var array
     */
    public $input;

    /**
     * @var Request
     */
    public $request;

    /**
     * @param $validator
     * @param array $input
     * @param Request $request
     */
    public function __construct(Request $request, array $input)
    {
        $this->input = $input;
        $this->request = $request;
    }

}