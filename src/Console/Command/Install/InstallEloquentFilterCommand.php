<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/20
 * Time: 3:11 PM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Install;


use EloquentFilter\ServiceProvider;
use Illuminate\Console\Command;

class InstallEloquentFilterCommand extends Command
{
    protected $signature = 'nichozuo:filter {--force}';

    protected $description = '安装tucker-eric/eloquentfilter插件，导出配置文件，--force覆盖';

    public function handle()
    {
        $this->line('Install tucker-eric/eloquentfilter ...');
        $this->line('Github: https://github.com/Tucker-Eric/EloquentFilter');
        $this->line('Offical: http://tucker-eric.github.io/EloquentFilter/');
        $this->line('1、publish configuration file');
        $this->call('vendor:publish', ['--provider' => ServiceProvider::class, '--force' => $this->option('force')]);
    }
}