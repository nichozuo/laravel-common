<?php

namespace Nichozuo\LaravelCommon\Console\Command\Generator;


use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MakeModelCommand extends GeneratorCommand
{
    protected $name = 'gen:model';
    protected $description = 'Create a new model class';
    protected $type = 'Model';

    protected function getStub()
    {
        return __DIR__ . '/stubs/model.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }

    protected function replaceOther(&$stub, $name)
    {
        $stub = str_replace(
            ['MyTable', 'MyFillable', 'MyRelations'],
            [$this->getTableName($name), $this->getFillable($name), ''],
            $stub
        );

        return $this;
    }

    /**
     * 获取表名
     *
     * @param $name
     * @return string
     */
    private function getTableName($name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);
        return Str::plural(Str::snake(class_basename($class)));
    }

    /**
     * 获取字段
     *
     * @param $name
     * @return bool|string
     */
    private function getFillable($name)
    {
        $columnList = Schema::getColumnListing($this->getTableName($name));
        $guardedList = ['id', 'created_at', 'updated_at', 'deleted_at'];

        $fillableList = '';
        foreach ($columnList as $key => $value) {
            if (!in_array($value, $guardedList)) {
                $fillableList .= "'{$value}',";
            }
        }
        $fillableList = substr($fillableList, 0, strlen($fillableList) - 1);
        return $fillableList;
    }
}