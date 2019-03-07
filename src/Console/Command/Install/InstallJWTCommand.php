<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 8:56 PM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Install;


use Illuminate\Console\Command;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class InstallJWTCommand extends Command
{
    protected $signature = 'nichozuo:jwt {--force}';

    protected $description = '安装tymon/jwt-auth插件，导出配置文件，--force覆盖';

    public function handle()
    {
        $this->line('Install tymon/jwt-auth ...');
        $this->line('Github: https://github.com/tymondesigns/jwt-auth');
        $this->line('Packagist: https://packagist.org/packages/tymon/jwt-auth');
        $this->line('Offical: https://jwt-auth.readthedocs.io/en/develop/');
        $this->line('1、publish configuration file');
        $this->call('vendor:publish', ['--provider' => LaravelServiceProvider::class, '--force' => $this->option('force')]);
        $this->line('2、generate secret key');
        $this->call('jwt:secret');


    }
}