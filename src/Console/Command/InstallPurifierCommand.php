<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 7:06 PM
 */

namespace Nichozuo\LaravelCommon\Console\Command;


use Illuminate\Console\Command;
use Mews\Purifier\PurifierServiceProvider;

class InstallPurifierCommand extends Command
{
    protected $signature = 'nichozuo:purifier {--force}';

    protected $description = '安装mews/purifier插件，导出配置文件，--force覆盖';

    public function handle()
    {
        $this->line('Install mews/purifier ...');
        $this->line('Github: https://github.com/mewebstudio/Purifier');
        $this->line('Packagist: https://packagist.org/packages/mews/purifier');
        $this->line('1、publish configuration file');
        $this->call('vendor:publish', ['--provider' => PurifierServiceProvider::class, '--force' => $this->option('force')]);
    }
}