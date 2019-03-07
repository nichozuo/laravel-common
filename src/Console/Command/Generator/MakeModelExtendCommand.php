<?php

namespace Nichozuo\LaravelCommon\Console\Command\Generator;


class MakeModelExtendCommand extends GeneratorCommand
{

    protected $name = 'gen:modelExt';
    protected $description = 'Create a new model extends class';
    protected $type = 'ModelExt';

    protected function getStub()
    {
        return __DIR__ . '/stubs/model.ext.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }

    protected function replaceOther(&$stub, $name)
    {
        $stub = str_replace(
            ['MyClass'],
            [$this->getClassName($name)],
            $stub
        );

        return $this;
    }

    private function getClassName($name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);
        return str_replace('Model', '', $class);
    }
}