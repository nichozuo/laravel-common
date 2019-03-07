<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 7:05 PM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Install;


use Illuminate\Console\Command;
use Nichozuo\LaravelCommon\LaravelCommonServiceProvider;

class InstallLangCommand extends Command
{
    protected $signature = 'nichozuo:lang {--force}';

    protected $description = '安装caouecs/laravel-lang插件，导出资源文件，--force覆盖';

    public function handle()
    {
        $this->line('Install caouecs/laravel-lang ...');
        $this->line('Github: https://github.com/caouecs/Laravel-lang');
        $this->line('Packagist: https://packagist.org/packages/caouecs/laravel-lang');
        $this->line('1、publish configuration file');
        $this->call('vendor:publish', ['--provider' => LaravelCommonServiceProvider::class, '--tag' => ['laravel_lang'], '--force' => $this->option('force')]);
    }
}