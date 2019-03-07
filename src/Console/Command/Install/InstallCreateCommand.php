<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/22
 * Time: 3:46 PM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Install;


use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCreateCommand extends Command
{
    protected $signature = 'nichozuo:create 
        {name : 要创建的表的名字，根据表名创建系列文件} 
        {--force : 是否覆盖，只针对Model有效}
        {--M|Model : 创建 Model}
        {--F|Factory : 创建 Factory}
        {--G|Migration : 创建 Migration}
        {--C|Controller : 创建 Controller}
        {--S|Seeder : 创建 Seeder}
        {--E|ModelFilter : 创建 ModelFilter}
        {--R|Request : 创建 Request}
        {--T|Test : 创建 Test}
    ';

    protected $description = '创建Model,Factory,Migration,Controller,Seeder,ModelFilter,Request,Test';

    public function handle()
    {
        // 获取参数
        $arg_name = $this->argument('name');

        $snake_name = Str::snake(Str::plural($arg_name, 2));
        $studly_name = Str::studly(Str::plural($arg_name, 1));

        $force = $this->option('force');

        if ($this->option('Model')) {
            $this->line('Creating Model ...');
            $this->call('make:model', [
                'name' => "Models/{$studly_name}",
                '--force' => $force
            ]);
        }

        if ($this->option('Factory')) {
            $this->line('Creating Factory ...');
            $this->call('make:factory', [
                'name' => $studly_name . 'Factory',
                '--model' => "Models/{$studly_name}",
            ]);
        }

        if ($this->option('Migration')) {
            $this->line('Creating Migration ...');
            $this->call('make:migration', [
                'name' => "create_{$snake_name}_table",
                '--create' => $snake_name,
            ]);
        }

        if ($this->option('Controller')) {
            $this->line('Creating Controller ...');
            $this->call('make:controller', [
                'name' => "Api/{$studly_name}Controller",
                '--api' => true,
            ]);
        }

        if ($this->option('Seeder')) {
            $this->line('Creating Seeder ...');
            $this->call('make:seeder', [
                'name' => "{$studly_name}TableSeeder",
            ]);
        }

        if ($this->option('ModelFilter')) {
            $this->line('Creating Model Filter ...');
            $this->call('model:filter', [
                'name' => $studly_name,
            ]);
        }

        if ($this->option('Request')) {
            $this->line('Creating Request ...');
            $this->call('make:request', [
                'name' => "{$studly_name}Request",
            ]);
        }

        if ($this->option('Test')) {
            $this->line('Creating Test ...');
            $this->call('make:test', [
                'name' => "Api/{$studly_name}ControllerTest",
            ]);
        }
    }
}