<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/30
 * Time: 17:11
 */

namespace App\Providers;


use App\Console\Commands\SeedCommandCustom;
use Illuminate\Support\ServiceProvider;

class SeedServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * @see \Illuminate\Foundation\Providers::registerSeedCommand()
     */
    public function register()
    {
        $this->app->singleton('command.seed', function ($app) {
            return new SeedCommandCustom($app['db']);
        });

        $this->commands('command.seed');
    }

    public function provides()
    {
        return ['command.seed'];
    }
}