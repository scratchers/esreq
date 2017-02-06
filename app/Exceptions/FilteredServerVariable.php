<?php

namespace App\Exceptions;

use Illuminate\Contracts\Foundation\Application;

class FilteredServerVariable
{
    protected $app;

    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get the $_SERVER variable filtered of all .env variables.
     *
     * @return array
     */
    public function get() : array
    {
        $array = $_SERVER;

        foreach ( $this->getEnvKeys() as $envKey ) {
            $array[$envKey] = 'FILTERED';
        }

        return $array;
    }

    protected function getEnvFile()
    {
        $filePath = $this->app->environmentPath() . '/' . $this->app->environmentFile();
        $envFile = @file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return is_array($envFile) ? $envFile : [];
    }

    protected function getEnvKeyFromLine($envLine)
    {
        return trim(current(explode('=', $envLine)));
    }

    protected function getEnvKeys()
    {
        $envFile = $this->getEnvFile();
        $envKeys = array_map([$this, 'getEnvKeyFromLine'], $envFile);
        return $envKeys;
    }
}
