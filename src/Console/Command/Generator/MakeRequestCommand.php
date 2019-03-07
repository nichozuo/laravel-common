<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/3/7
 * Time: 2:48 AM
 */

namespace Nichozuo\LaravelCommon\Console\Command\Generator;


use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakeRequestCommand extends GeneratorCommand
{
    protected $name = 'gen:request';
    protected $description = 'Create a new request class';
    protected $type = 'Request';

    protected function getStub()
    {
        return __DIR__ . '/stubs/request.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Modules';
    }

    protected function replaceOther(&$stub, $name)
    {
        $stub = str_replace(
            ['MyModelName', 'MyFields'],
            [$this->getModelName($name, 'Request'), $this->getFields($name)],
            $stub
        );

        return $this;
    }

    private function getFields($name)
    {
        $modelName = $this->getModelName($name, 'Request');
        $tableName = str_plural(snake_case(class_basename($modelName)));

        $strRequest = '';
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        // 获取表字段数组
        $columnList = Schema::getColumnListing($tableName);
        $guardedList = ['id', 'created_at', 'updated_at', 'deleted_at'];
        $columns = array_column($columnList, null, 1);

        // 遍历数组，获取类型
        $conn = DB::connection();
        $columnTypeList = array();
        foreach ($columns as $item) {
            if (!in_array($item, $guardedList)) {
                $temp = $conn->getDoctrineColumn($tableName, $item);
                $columnTypeList[] = [
                    $item,
                    $this->getRequired($temp->getNotNull(), $temp->getDefault()),
                    $this->getValidateType($temp->getType()->getName()),
                ];
            }
        }

        foreach ($columnTypeList as $item) {
            $strRequest .= "'{$item[0]}' => '$item[1]|{$item[2]}',\r\n";
        }

        return $strRequest;
    }

    private function getRequired($notNull, $default)
    {
        return ($notNull === true && $default === null) ? 'required' : 'nullable';
    }

    private function getValidateType($columnType)
    {
        switch ($columnType) {
            case 'float':
            case 'decimal':
                return 'numeric';
            case 'smallint':
            case 'int':
            case 'integer':
                return 'integer';
            case 'date':
            case 'datetime':
                return 'date';
            case 'boolean':
                return 'boolean';
            case 'text':
            case 'varchar':
            case 'string':
                return 'string';
            case 'json':
                return 'json';
            default:
                throw new \Exception('unkown type: ' . $columnType);
        }
    }
}