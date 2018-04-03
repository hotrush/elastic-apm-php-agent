<?php

namespace Hotrush\Stores;

use \Hotrush\Events\Error;

/**
 *
 * Registry for captured the Errors/Excpetions
 *
 */
class ErrorsStore extends Store
{

    /**
     * Register an Error Event
     *
     * @param \Hotrush\Events\Error $error
     * @return void
     */
    public function register(Error $error)
    {
        $this->store [] = $error;
    }

}
