<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/15
 * Time: 8:21 PM
 */

namespace Nichozuo\LaravelCommon\Exceptions;


class ValidationException extends BaseException
{
    public static function create(array $errorMessage, array $params, array $rules)
    {
        return new static('参数验证失败', 10000, [
            'errors' => $errorMessage,
            'params' => $params,
            'rules' => $rules
        ]);
    }
}