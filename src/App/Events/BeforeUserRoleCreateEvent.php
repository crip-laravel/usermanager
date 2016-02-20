<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Events\CripEvent;
use Illuminate\Http\Request;

/**
 * Class BeforeUserRoleCreateEvent
 * @package Crip\UserManager\App\Events
 */
class BeforeUserRoleCreateEvent extends CripEvent
{
    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}