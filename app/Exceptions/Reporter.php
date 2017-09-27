<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use App;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

        if ( $exception instanceof HttpException ) {
            $key = 'exception-handler.'.HttpException::class.'.ignore-routes';
            $ignored = collect(config($key, []));

            if ($ignored->contains(request()->path())) {
                return false;
            }
        }

        return true;
    }
}
