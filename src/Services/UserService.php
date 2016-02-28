<?php namespace Crip\UserManager\Services;

use Auth;
use Crip\Core\Contracts\ICripObject;
use Crip\Core\Events\EventCollector;
use Crip\Core\Exceptions\BadConfigurationException;
use Crip\UserManager\App\Events\UserCreate;
use Crip\UserManager\App\Events\UserCreateValidate;
use Crip\UserManager\App\Events\UserUpdate;
use Crip\UserManager\App\Events\UserUpdateValidate;
use Crip\UserManager\App\UserManager;
use Crip\UserManager\Exceptions\ActionCanceledException;
use Crip\UserManager\Repositories\UserRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class UserService
 * @package Crip\UserManager\App\Services
 */
class UserService implements ICripObject
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Dispatcher
     */
    private $events;

    /**
     * @param Dispatcher $events
     * @param UserRepository $user
     */
    public function __construct(Dispatcher $events, UserRepository $user)
    {
        $this->userRepository = $user;
        $this->events = $events;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|null
     *
     * @throws ActionCanceledException
     */
    public function create(Request $request)
    {
        $event_instance = new UserCreate($request, $this->setUser());
        if($this->events->fire($event_instance) === false) {
            throw new ActionCanceledException('user-create');
        }

        $event_results = $this->events->fire(new UserCreateValidate($request));
        $validation_result = (new EventCollector)
            ->push($event_results)
            ->asValidator();

        if ($validation_result !== null) {
            return $validation_result;
        }

        $this->userRepository->create($request->all());

        return $this->authenticate($request);
    }

    /**
     * @param int $id
     * @param Request $request
     *
     * @return \Crip\Core\Data\Model|\Illuminate\Http\JsonResponse|null
     *
     * @throws ActionCanceledException
     */
    public function update($id, Request $request)
    {
        $instance = $this->userRepository->find($id);
        $event_instance = new UserUpdate($instance, $id, $request, $this->setUser());
        if($this->events->fire($event_instance) === false) {
            throw new ActionCanceledException('user-update');
        }

        $event_results = $this->events->fire(new UserUpdateValidate($id, $request, $instance));
        $validation_result = (new EventCollector)
            ->push($event_results)
            ->asValidator();

        if ($validation_result !== null) {
            return $validation_result;
        }

        return $this->userRepository->update($request->all(), $id, $instance);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = app(JWTAuth::class)->attempt($credentials)) {
                return response()->json([UserManager::package()->trans('auth.incorrect_attempt')], 401);
            }
        } catch (JWTException $e) {
            return response()->json([UserManager::package()->trans('auth.error')], 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * Set user property from package configurations
     *
     * @return UserService
     * @throws BadConfigurationException
     */
    private function setUser()
    {
        return $this->user = Auth::check() ? Auth::user() : app(config('auth.model'));
    }

}