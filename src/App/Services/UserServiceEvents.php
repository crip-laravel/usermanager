<?php namespace Crip\UserManager\App\Services;

use Crip\Core\Contracts\ICripObject;
use Crip\Core\Events\EventCollector;
use Crip\UserManager\App\Events\AfterUserCreateEvent;
use Crip\UserManager\App\Events\AfterUserRoleCreateEvent;
use Crip\UserManager\App\Events\BeforeUserCreateEvent;
use Crip\UserManager\App\Events\BeforeUserRoleCreateEvent;
use Crip\UserManager\App\Events\UserCreateValidateEvent;
use Crip\UserManager\App\Events\UserRoleCreateValidateEvent;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

/**
 * Class UserServiceEvents
 * @package Crip\UserManager\App\Services
 */
class UserServiceEvents extends EventCollector
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
     * Fires user.creating and BeforeUserCreateEvent events
     *
     * @param Request $request
     * @return $this
     */
    protected function onBeforeCreateUser(Request $request)
    {
        return $this->clearEvents()
            ->push($this->events->fire(new BeforeUserCreateEvent($request)), BeforeUserCreateEvent::class)
            ->push($this->events->fire('user.creating', [$request]), 'user.creating');
    }

    /**
     * Fires user.created and AfterUserCreateEvent events
     *
     * @param $user
     * @return $this
     */
    protected function onAfterCreateUser($user)
    {
        return $this->clearEvents()
            ->push($this->events->fire(new AfterUserCreateEvent($user)), AfterUserCreateEvent::class)
            ->push($this->events->fire('user.created', [$user]), 'user.created');
    }

    /**
     * Fires user.creating.validate and UserCreateValidateEvent events
     *
     * @param array $input
     * @param Request $request
     *
     * @return $this
     */
    protected function onValidateCreateUser(Request $request, array $input)
    {
        $event = 'user.creating.validate';
        return $this->clearEvents()
            ->push($this->events->fire(new UserCreateValidateEvent($request, $input)), UserCreateValidateEvent::class)
            ->push($this->events->fire($event, [$request, $input]), $event);
    }


    /**
     * Fires user.creating and BeforeUserCreateEvent events
     *
     * @param Request $request
     * @return $this
     */
    protected function onBeforeCreateRole(Request $request)
    {
        return $this->clearEvents()
            ->push($this->events->fire(new BeforeUserRoleCreateEvent($request)), BeforeUserRoleCreateEvent::class)
            ->push($this->events->fire('user.role.creating', [$request]), 'user.role.creating');
    }

    /**
     * Fires user.created and AfterUserCreateEvent events
     *
     * @param $user
     * @return $this
     */
    protected function onAfterCreateRole($user)
    {
        return $this->clearEvents()
            ->push($this->events->fire(new AfterUserRoleCreateEvent($user)), AfterUserRoleCreateEvent::class)
            ->push($this->events->fire('user.role.created', [$user]), 'user.role.created');
    }

    /**
     * Fires user.creating.validate and UserCreateValidateEvent events
     *
     * @param array $input
     * @param Request $request
     *
     * @return $this
     */
    protected function onValidateCreateRole(Request $request, array $input)
    {
        $event = 'user.role.creating.validate';
        return $this->clearEvents()
            ->push($this->events->fire(
                new UserRoleCreateValidateEvent($request, $input)),
                UserRoleCreateValidateEvent::class
            )
            ->push($this->events->fire($event, [$request, $input]), $event);
    }
}