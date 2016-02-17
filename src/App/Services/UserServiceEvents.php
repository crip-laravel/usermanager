<?php namespace Crip\UserManager\App\Services;

use Crip\Core\Contracts\ICripObject;
use Crip\UserManager\App\Events\BeforeUserCreateEvent;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;

/**
 * Class UserServiceEvents
 * @package Crip\UserManager\App\Services
 */
class UserServiceEvents implements ICripObject
{
    /**
     * @var Dispatcher
     */
    private $events;

    /**
     * @param Dispatcher $events
     */
    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * Fires user.attempt and BeforeUserCreateEvent events
     *
     * @param Request $request
     */
    protected function onBeforeCreateUser(Request $request)
    {
        $this->events->fire(new BeforeUserCreateEvent($request));
        $this->events->fire('user.attempt', [$request]);
    }
}