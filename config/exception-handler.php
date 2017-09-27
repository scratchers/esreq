<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

return [
    HttpException::class => [
        'ignore-routes' => [
            '.well-known/assetlinks.json',
            'apple-app-site-association',
            '.well-known/apple-app-site-association',
        ],
    ],
];
