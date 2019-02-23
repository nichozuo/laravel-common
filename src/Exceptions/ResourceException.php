<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/2/1
 * Time: 6:20 PM
 */

namespace Nichozuo\LaravelCommon\Exceptions;


class ResourceException extends BaseException
{
    public static function undefined(string $routeName)
    {
        return new static('资源未定义', 30000, [
            'route_name' => $routeName,
        ]);
    }
}