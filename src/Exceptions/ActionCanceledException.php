<?php namespace Crip\UserManager\Exceptions;

use Crip\Core\Exceptions\BaseCripException;

/**
 * Class ActionCanceledException
 * @package Crip\UserManager\Exceptions
 */
class ActionCanceledException extends BaseCripException
{
    /**
     * Create a new permission denied exception instance.
     *
     * @param string $action
     */
    public function __construct($action)
    {
        $this->message = sprintf('Action [%s] is canceled.', $action);
        parent::__construct($this, $this->message);
    }
}