<?php

namespace Nichozuo\LaravelCommon\Console\Command\Generator;

use Symfony\Component\Console\Input\InputOption;

abstract class GeneratorCommand extends \Illuminate\Console\GeneratorCommand
{
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'force.']
        ];
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        return $this->replaceOther($stub, $name)->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    abstract protected function replaceOther(&$stub, $name);

    protected function getModelName($name, $replace)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);
        return str_replace($replace, '', $class);
    }
}