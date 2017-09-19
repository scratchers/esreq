<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use App;

class Reporter
{
    public static function wants(Exception $exception) : bool
    {
        if (App::environment() === 'testing') {
            return false;
        }

        if ( $exception instanceof AuthenticationException ) {
            return false;
        }

        return true;
    }
}
