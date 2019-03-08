<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/3/8
 * Time: 7:20 PM
 */

namespace Nichozuo\LaravelCommon\Exceptions;


use \App\Exceptions\ProjectExceptionTrait;

class ProjectException extends BaseException
{
    use ProjectExceptionTrait;
}