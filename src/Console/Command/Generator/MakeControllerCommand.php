<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/3/7
 * Time: 2:31 AM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Generator;


class MakeControllerCommand extends GeneratorCommand
{
    protected $name = 'gen:controller';
    protected $description = 'Create a new controller class';
    protected $type = 'Controller';

    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Modules';
    }

    protected function replaceOther(&$stub, $name)
    {
        $stub = str_replace(
            ['MyModelName'],
            [$this->getModelName($name,'Controller')],
            $stub
        );

        return $this;
    }
}