<?php namespace Crip\UserManager\Exceptions;

use Crip\Core\Exceptions\BaseCripException;

/**
 * Class RoleDeniedException
 * @package Crip\UserManager\Exceptions
 */
class RoleDeniedException extends BaseCripException
{

    /**
     * Create a new role denied exception instance.
     *
     * @param string $role
     */
    public function __construct($role)
    {
        $this->message = sprintf('You don\'t have required [%s] role', $role);
        parent::__construct($this, $this->message);
    }

}