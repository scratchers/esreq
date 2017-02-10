<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;

class Reporter
{
    public static function wants(Exception $exception) : bool
    {
        if ( $exception instanceof AuthenticationException ) {
            return false;
        }

        return true;
    }
}
