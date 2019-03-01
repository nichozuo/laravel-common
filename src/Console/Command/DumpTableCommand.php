<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/15
 * Time: 8:30 PM
 */

namespace Nichozuo\LaravelCommon\Console\Command;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DumpTableCommand extends Command
{
    protected $table_name;

    protected $signature = 'nichozuo:dump {name}';

    protected $description = 'Dump table codes for Models';

    public function handle()
    {
        // 获取参数
        $this->table_name = $this->argument('name');
        $this->table_name = Str::plural(Str::snake(class_basename($this->table_name)));

        // 获取表名
        $this->line('');

        // 生成 $table
        $this->line($this->get_table());

        // 生成 $fillable
        $this->line($this->get_fillable());
        $this->line('');

        // 生成 $request
        $this->line($this->getRequest());
        $this->line('');
    }

    private function get_table()
    {
        return sprintf('protected $table = \'%s\';', $this->table_name);
    }

    private function get_fillable()
    {
        $column_list = Schema::getColumnListing($this->table_name);
        $guarded_list = ['id', 'created_at', 'updated_at', 'deleted_at'];

        $fillable = '';
        foreach ($column_list as $key => $value) {
            if (!in_array($value, $guarded_list)) {
                $fillable .= '\'' . $value . '\',';
            }
        }
        $fillable = substr($fillable, 0, strlen($fillable) - 1);
        return 'protected $fillable = [' . $fillable . '];';
    }

    private function getRequest()
    {
        $strRequest = '';
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        // 获取表字段数组
        $columns_list = Schema::getColumnListing($this->table_name);
        $guarded_list = ['id', 'created_at', 'updated_at', 'deleted_at'];
        $columns = array_column($columns_list, null, 1);

        // 遍历数组，获取类型
        $conn = DB::connection();
        $columns_type_list = array();
        foreach ($columns as $item) {
            if (!in_array($item, $guarded_list)) {
                $temp = $conn->getDoctrineColumn($this->table_name, $item);
                $columns_type_list[] = [
                    $item,
                    $this->getRequired($temp->getNotNull(), $temp->getDefault()),
                    $this->getValidateType($temp->getType()->getName()),
                ];
            }
        }

        foreach ($columns_type_list as $item) {
            $strRequest .= "'{$item[0]}' => '$item[1]|{$item[2]}',\r\n";
        }

        $strRequest .= "\r\n\r\n";

        foreach ($columns_type_list as $item) {
            $strRequest .= "'{$item[0]}' => '',\r\n";
        }

        return $strRequest;
    }

    private function getRequired($notNull, $default)
    {
        return ($notNull === true && $default === false) ? 'required' : 'nullable';
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