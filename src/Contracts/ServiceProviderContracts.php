<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/15
 * Time: 9:17 PM
 */

namespace Nichozuo\LaravelCommon\Contracts;


interface ServiceProviderContracts
{
    public function boot();

    public function register();

    function publishConfigs();

    function publishRoutes();

    function publishMigrations();

    function publishCommands();

    function mergeConfig();

}