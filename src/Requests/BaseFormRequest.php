<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 5:34 PM
 */

namespace Nichozuo\LaravelCommon\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
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

    public function getCleanData(array $hashIds = null)
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

            // 处理HashIds
            if($hashIds != null){
                if(in_array($key, $hashIds)){
                    $params[$key] = Hashids::decode($params[$key])[0];
                }
            }
        }

        return $params;
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

    protected function getActionName()
    {
        if ($this->route() == null) {
            return [];
        }
        $action_name = $this->route()->getActionName();
        return explode('@', $action_name)[1];
    }
}