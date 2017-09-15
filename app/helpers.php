<?php

function requestExpectsJson() : bool
{
    $request = request();

    if ($request->expectsJson()) {
        return true;
    }

    return $request->exists('json');
}
