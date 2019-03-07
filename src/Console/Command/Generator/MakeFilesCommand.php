<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/3/7
 * Time: 1:57 PM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Generator;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeFilesCommand extends GeneratorCommand
{
    protected $name = 'gen:files';
    protected $description = '创建模板文件';
    protected $type = 'All';

    public function handle()
    {
        if ($this->option('models')) {
            $this->createModel();
            $this->createModelExt();
            $this->createModelFilter();
        }

        if ($this->option('controllers')) {
            $this->createController();
            $this->createRequest();
        }
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createModel()
    {
        $this->call('gen:model', [
            'name' => $this->argument('name') . '/' . $this->argument('name'),
        ]);
    }

    private function createModelExt()
    {
        $this->call('gen:modelExt', [
            'name' => $this->argument('name') . '/' . $this->argument('name') . 'Model',
        ]);
    }

    private function createModelFilter()
    {
        $this->call('gen:modelFilter', [
            'name' => $this->argument('name') . '/' . $this->argument('name') . 'Filter',
        ]);
    }

    private function createController()
    {
        $this->call('gen:controller', [
            'name' => $this->argument('module') . '/' . $this->argument('name') . '/' . $this->argument('name') . 'Controller',
        ]);
    }

    private function createRequest()
    {
        $this->call('gen:request', [
            'name' => $this->argument('module') . '/' . $this->argument('name') . '/' . $this->argument('name') . 'Request',
        ]);
    }

    protected function getStub()
    {
    }

    protected function getDefaultNamespace($rootNamespace)
    {
    }

    protected function getOptions()
    {
        return [
            ['models', 'm', InputOption::VALUE_NONE, 'Generate a model, model extends, model filter files'],
            ['controllers', 'c', InputOption::VALUE_NONE, 'Create a controller, request files'],
//            ['database', 'd', InputOption::VALUE_NONE, 'Create a new factory for the model'],
//
//            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
//
//            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
//
//            ['pivot', 'p', InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model'],
//
//            ['resource', 'r', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller'],
        ];
    }

    protected function replaceOther(&$stub, $name)
    {
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, '模型名称'],
            ['module', InputArgument::REQUIRED, '模块名称'],
        ];
    }
}