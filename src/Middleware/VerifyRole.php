<?php namespace Crip\UserManager\Middleware;

use Crip\Core\Middleware\CripCoreMiddleware;
use Crip\UserManager\Exceptions\RoleDeniedException;

/**
 * Class VerifyRole
 * @package Crip\UserManager\Middleware
 */
class VerifyRole extends CripCoreMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int|string $role
     *
     * @return mixed
     *
     * @throws RoleDeniedException
     */
    public function handle($request, \Closure $next, $role)
    {
        if ($this->auth->check() && $this->auth->user()->is($role)) {
            return $next($request);
        }
        throw new RoleDeniedException($role);
    }
}