<?php namespace Crip\UserManager\App\Services;

use Auth;
use Crip\Core\Exceptions\BadConfigurationException;
use Crip\Core\Exceptions\BadEventResultException;
use Crip\UserManager\App\Repositories\UserRepository;
use Crip\UserManager\App\Traits\CripUser;
use Crip\UserManager\App\UserManager;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class UserService
 * @package Crip\UserManager\App\Services
 */
class UserService extends UserServiceEvents
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $user_class = '';

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param Dispatcher $events
     * @param UserRepository $user
     */
    public function __construct(Dispatcher $events, UserRepository $user)
    {
        parent::__construct($events);
        $this->userRepository = $user;
    }

    /**
     * @param Request $request
     * @return Model
     * @throws BadConfigurationException
     * @throws BadEventResultException
     */
    public function create(Request $request)
    {
        $this->setUser();
        $this->onBeforeCreateUser($request);

        $input = $this->userRepository->onlyFillable($request->all());
        $validation_result = $this->validateOnEvents('onValidateCreateUser', $request, $input);

        if ($validation_result !== null) {
            return $validation_result;
        }

        $user = $this->userRepository->create($input);

        $this->onAfterCreateUser($user);

        return $this->authenticate($request);
    }

    /**
     * @param int $id
     * @param Request $request
     *
     * @return Model|\Illuminate\Http\JsonResponse
     *
     * @throws BadConfigurationException
     */
    public function update($id, Request $request)
    {
        $this->setUser();
        $this->onBeforeUpdateUser($id, $request);

        $input = $this->userRepository->onlyFillable($request->all());
        $instance = $this->userRepository->find($id);
        $validation_result = $this->validateOnEvents('onValidateUpdateUser', $request, $input, $id, $instance);

        if ($validation_result !== null) {
            return $validation_result;
        }

        $user = $this->userRepository->update($input, $id);

        $this->onAfterUpdateUser($id, $user);

        return $user;
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

    public function createRole(Request $request)
    {
        $this->setUser();
        $this->onBeforeCreateRole($request);

        //$this->onAfterCreateRole()

    }

    /**
     * Set user property from package configurations
     *
     * @return UserService
     * @throws BadConfigurationException
     */
    private function setUser()
    {
        $this->user_class = UserManager::package()->config('user');
        if ($this->checkUserSubclass()) {
            $this->user = Auth::check() ? Auth::user() : app()->make($this->user_class);

            return $this;
        }

        $message = 'User class should be an instance of `%s` and `%s`';
        $message = sprintf($message, CripUser::class, Model::class);

        throw new BadConfigurationException($this, $message);
    }

    /**
     * Check is user_class instance of Authenticatable and Model classes
     *
     * @return bool
     */
    private function checkUserSubclass()
    {
        if (!in_array(CripUser::class, class_uses($this->user_class))) {
            return false;
        }

        if (!is_subclass_of($this->user_class, Model::class)) {
            return false;
        }

        return true;
    }

}