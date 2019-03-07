<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/3/7
 * Time: 2:28 AM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Generator;


class MakeModelFilterCommand extends GeneratorCommand
{
    protected $name = 'gen:modelFilter';
    protected $description = 'Create a new model filter class';
    protected $type = 'ModelFilter';

    protected function getStub()
    {
        return __DIR__ . '/stubs/model.filter.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }

    protected function replaceOther(&$stub, $name)
    {
        return $this;
    }
}