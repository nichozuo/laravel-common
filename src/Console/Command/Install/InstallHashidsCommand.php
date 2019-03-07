<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 7:05 PM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Install;


use Illuminate\Console\Command;
use Vinkla\Hashids\HashidsServiceProvider;

class InstallHashidsCommand extends Command
{
    protected $signature = 'nichozuo:hashids {--force}';

    protected $description = '安装vinkla/hashids插件，导出配置文件，--force覆盖';

    public function handle()
    {
        $this->line('Install vinkla/hashids ...');
        $this->line('Github: https://github.com/vinkla/laravel-hashids');
        $this->line('Packagist: https://packagist.org/packages/vinkla/hashids');
        $this->line('1、publish configuration file');
        $this->call('vendor:publish', ['--provider' => HashidsServiceProvider::class, '--force' => $this->option('force')]);
    }
}