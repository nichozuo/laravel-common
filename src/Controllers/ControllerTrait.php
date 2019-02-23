<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 11:14 PM
 */

namespace Nichozuo\LaravelCommon\Controllers;


use Illuminate\Support\Facades\Validator;
use Nichozuo\LaravelCommon\Exceptions\ValidationException;
use Vinkla\Hashids\Facades\Hashids;

trait ControllerTrait
{
    protected function getId($id_column_name = 'id')
    {
        // 获取请求参数
        $params = request()->only([$id_column_name]);

        // 判断请求是否包含id字段
        if (!isset($params[$id_column_name])) {
            throw ValidationException::create(['message' => '缺少id参数'], $params, null);
        }

        // 获取id类型
        $is_integer = is_int($params[$id_column_name]);

        // 根据id类型，判断是否hashid规则
        if ($is_integer) {
            $rules[$id_column_name] = 'required|integer';
        } else {
            $rules[$id_column_name] = 'required|string|size:10';
        }

        // 验证数据
        $validator = Validator::make($params, $rules);
        if ($validator->fails()) {
            throw ValidationException::create($validator->errors()->messages(), $params, $rules);
        }

        // 返回id
        return ($is_integer) ? (int)$params[$id_column_name] : Hashids::decode($params[$id_column_name])[0];
    }

    protected function toJson($data = null, $isPage = false)
    {
        if ($isPage) {
            $data = $data->toArray();
            return [
                'code' => 1,
                'msg' => 'ok',
                'data' => [
                    'list' => $data['data'],
                    'page' => [
                        'total' => $data['total'],
                        'current_page' => $data['current_page'],
                        'last_page' => $data['last_page'],
                        'per_page' => $data['per_page'],
                    ]
                ]
            ];
        } else {
            return [
                'code' => 1,
                'msg' => 'ok',
                'data' => $data
            ];
        }
    }

    protected function getPerPage()
    {
        $params = request()->only('per_page');
        if ($params == null) {
            return 10;
        }

        $validator = Validator::make($params, array(
            'per_page' => 'nullable|integer|in:10,20,30,40,50,60,70,80,90,100'
        ));
        if ($validator->fails()) {
            return 10;
        }
        return (int)$params['per_page'];
    }
}