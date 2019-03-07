<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/15
 * Time: 8:41 PM
 */

namespace Nichozuo\LaravelCommon;

use Nichozuo\LaravelCommon\Console\Command\DumpTableCommand;
use Nichozuo\LaravelCommon\Console\Command\Generator\MakeControllerCommand;
use Nichozuo\LaravelCommon\Console\Command\Generator\MakeFilesCommand;
use Nichozuo\LaravelCommon\Console\Command\Generator\MakeModelCommand;
use Nichozuo\LaravelCommon\Console\Command\Generator\MakeModelExtendCommand;
use Nichozuo\LaravelCommon\Console\Command\Generator\MakeModelFilterCommand;
use Nichozuo\LaravelCommon\Console\Command\Generator\MakeRequestCommand;
use Nichozuo\LaravelCommon\Console\Command\Install\InstallCreateCommand;
use Nichozuo\LaravelCommon\Console\Command\Install\InstallEloquentFilterCommand;
use Nichozuo\LaravelCommon\Console\Command\Install\InstallHashidsCommand;
use Nichozuo\LaravelCommon\Console\Command\Install\InstallJWTCommand;
use Nichozuo\LaravelCommon\Console\Command\Install\InstallLangCommand;
use Nichozuo\LaravelCommon\Console\Command\Install\InstallPurifierCommand;
use Nichozuo\LaravelCommon\ServiceProvider\BaseServiceProvider;

class LaravelCommonServiceProvider extends BaseServiceProvider
{
    function publishConfigs()
    {
        // TODO: Implement publishConfigs() method.
    }

    function publishRoutes()
    {
        // TODO: Implement publishRoutes() method.
    }

    function publishResources()
    {
        $basePath = dirname(__DIR__);

        $publishable = [
            'laravel_lang' => [
                "{$basePath}/vendor/caouecs/laravel-lang/src/zh-CN" => resource_path('lang/zh-CN'),
            ]
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    function publishMigrations()
    {
        // TODO: Implement publishMigrations() method.
    }

    function publishCommands()
    {
        $this->commands([
            DumpTableCommand::class,
            InstallHashidsCommand::class,
            InstallLangCommand::class,
            InstallPurifierCommand::class,
            InstallJWTCommand::class,
            InstallEloquentFilterCommand::class,
            InstallCreateCommand::class,

            MakeControllerCommand::class,
            MakeFilesCommand::class,
            MakeModelCommand::class,
            MakeModelExtendCommand::class,
            MakeModelFilterCommand::class,
            MakeRequestCommand::class
        ]);
    }

    function mergeConfig()
    {
        // TODO: Implement mergeConfig() method.
    }
}