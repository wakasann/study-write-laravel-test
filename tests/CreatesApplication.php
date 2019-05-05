<?php

namespace Tests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     * @link https://stackoverflow.com/a/32053026
     * @link https://mattstauffer.com/blog/environment-specific-variables-in-laravels-testing-environment/
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        if (file_exists(dirname(__DIR__) . '/.env.test')) {
            (new \Dotenv\Dotenv(dirname(__DIR__), '.env.test'))->load();
        }
        $app->make(Kernel::class)->bootstrap();

        Hash::setRounds(4);

        return $app;
    }
}
