<?php namespace Crip\UserManager\App\Events;

use Crip\Core\Events\CripEvent;
use Illuminate\Http\Request;

/**
 * Class BeforeUserCreateEvent
 * @package Crip\UserManager\App\Events
 */
class BeforeUserCreateEvent extends CripEvent
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