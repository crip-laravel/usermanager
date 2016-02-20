<?php namespace Crip\UserManager\App\Services;

use Crip\Core\Exceptions\BadConfigurationException;
use Crip\Core\Exceptions\BadEventResultException;
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
     * @param UserRepository $user
     */
    public function __construct(Dispatcher $events, UserRepository $user)
    {
        parent::__construct($events);
        $this->userRepository = $user;
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return mixed
     * @throws BadConfigurationException
     */
    public function redirectToSocialProvider($provider)
    {
        return app(SocialiteService::class)->redirect($provider);
    }

    /**
     * Handle social provider callback action for authorisation
     *
     * @param $provider
     */
    public function handleSocialProviderCallback($provider)
    {
        app(SocialiteService::class)->handle($provider);
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
        if($validation_result !== null) {
            return $validation_result;
        }

        $user = $this->userRepository->create($input);

        $this->onAfterCreateUser($user);

        return $user;
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

        $message = 'User class should be an instance of `%s` and `%s`';
        $message = sprintf($message, Authenticatable::class, Model::class);

        throw new BadConfigurationException($this, $message);
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