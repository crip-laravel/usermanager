<?php namespace Crip\UserManager\App\Services;

use Crip\Core\Exceptions\BadConfigurationException;
use Crip\UserManager\App\Repositories\UserRepository;
use Crip\UserManager\App\UserManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


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
     * @param UserRepository $userRepository
     */
    public function __construct(Dispatcher $events, UserRepository $userRepository)
    {
        parent::__construct($events);
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @throws BadConfigurationException
     */
    public function create(Request $request)
    {
        $this->setUser();
        $this->onBeforeCreateUser($request);

        dd($this->userRepository->create($request->all()));
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
            $this->user = app()->make($this->user_class);
            return $this;
        }

        $error_message = 'User class should be an instance of `%s` and `%s`';
        throw new BadConfigurationException($this, sprintf($error_message, Authenticatable::class, Model::class));
    }

    /**
     * Check is user_class instance of Authenticatable and Model classes
     *
     * @return bool
     */
    private function checkUserSubclass()
    {
        if (!is_subclass_of($this->user_class, Authenticatable::class)) {
            return false;
        }

        if (!is_subclass_of($this->user_class, Model::class)) {
            return false;
        }
        return true;
    }
}