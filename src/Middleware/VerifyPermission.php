<?php namespace Crip\UserManager\Middleware;

use Crip\Core\Middleware\CripCoreMiddleware;
use Crip\UserManager\Exceptions\PermissionDeniedException;

/**
 * Class VerifyPermission
 * @package Crip\UserManager\Middleware
 */
class VerifyPermission extends CripCoreMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int|string $permission
     *
     * @return mixed
     *
     * @throws PermissionDeniedException
     */
    public function handle($request, \Closure $next, $permission)
    {
        if ($this->auth->check() && $this->auth->user()->can($permission)) {
            return $next($request);
        }

        throw new PermissionDeniedException($permission);
    }
}