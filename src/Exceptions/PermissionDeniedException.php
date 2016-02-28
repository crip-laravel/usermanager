<?php namespace Crip\UserManager\Exceptions;

use Crip\Core\Exceptions\BaseCripException;

/**
 * Class PermissionDeniedException
 * @package Crip\UserManager\Exceptions
 */
class PermissionDeniedException extends BaseCripException
{

    /**
     * Create a new permission denied exception instance.
     *
     * @param string $permission
     */
    public function __construct($permission)
    {
        $this->message = sprintf('You don\'t have a required [%s] permission', $permission);
        parent::__construct($this, $this->message);
    }

}