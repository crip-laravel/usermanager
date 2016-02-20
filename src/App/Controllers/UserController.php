<?php namespace Crip\UserManager\App\Controllers;

use Crip\Core\Contracts\ICripObject;
use Crip\UserManager\App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Response;

/**
 * Class UserController
 * @package Crip\UserManager\App\Controllers
 */
class UserController extends Controller implements ICripObject
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param UserService $userService
     * @param Request $request
     */
    public function __construct(UserService $userService, Request $request)
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate and createUser methods. We don't want to
        // prevent the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate', 'createUser']]);

        $this->userService = $userService;
        $this->request = $request;
    }

    /**
     * Create user in database
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createUser()
    {
        return $this->userService->create($this->request);
    }

    public function authenticate()
    {
        return $this->userService->authenticate($this->request);
    }

}