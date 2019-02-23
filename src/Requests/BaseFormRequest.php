<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 5:34 PM
 */

namespace Nichozuo\LaravelCommon\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Nichozuo\LaravelCommon\Exceptions\ValidationException;
use Vinkla\Hashids\Facades\Hashids;

class BaseFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function getHashids($key = 'id')
    {
        $params = $this->getCleanData();
        if (array_key_exists($key, $params)) {
            return Hashids::decode($params[$key])[0];
        } else {
            throw ValidationException::create([], [], []);
        }
    }

    public function getCleanData()
    {
        // 通过验证的请求参数数组
        $params = $this->validated();
        // 验证规则
        $rules = $this->rules();

        foreach ($rules as $key => $value) {
            // 处理rules中，带string的参数，进行xss过滤
            if (stripos($value, 'string') !== false) {
                if (array_key_exists($key, $params)) {
                    $params[$key] = clean($params[$key]);
                }
            }

            // 如果传入的是array数组，就把他变成string
//            if (stripos($value, 'array') !== false) {
//                if (array_key_exists($key, $params)) {
//                    $params[$key] = implode(',', $params[$key]);
//                }
//            }
        }

        return $params;
    }

    protected function getActionName()
    {
        $action_name = $this->route()->getActionName();
        return explode('@', $action_name)[1];
    }
}