<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/15
 * Time: 10:17 PM
 */

namespace Nichozuo\LaravelCommon\ServiceProvider;


use Illuminate\Support\ServiceProvider;

abstract class BaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishConfigs();
        $this->publishRoutes();
        $this->publishResources();
        $this->publishMigrations();
        if ($this->app->runningInConsole()) {
            $this->publishCommands();
        }
    }

    abstract function publishConfigs();

    abstract function publishRoutes();

    abstract function publishResources();

    abstract function publishMigrations();

    abstract function publishCommands();

    public function register()
    {
        $this->mergeConfig();
    }

    abstract function mergeConfig();
}