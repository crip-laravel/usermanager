<?php namespace Crip\UserManager\App\Controllers;

use Crip\Core\Contracts\ICripObject;
use Crip\UserManager\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
        // and allow to register in our system
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

    /**
     * Update user in database
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateUser($id)
    {
        return $this->userService->update($id, $this->request);
    }

    public function authenticate()
    {
        return $this->userService->authenticate($this->request);
    }

}