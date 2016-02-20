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

    public function __construct(UserService $userService, Request $request)
    {
        $this->userService = $userService;
        $this->request = $request;
    }

    public function createUser()
    {
        return $this->userService->create($this->request);
    }

    public function user($id)
    {
        return Response::json(['user' => $id]);
    }

}