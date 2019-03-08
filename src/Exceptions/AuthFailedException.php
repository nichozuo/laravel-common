<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 6:09 PM
 */

namespace Nichozuo\LaravelCommon\Exceptions;


class AuthFailedException extends BaseException
{
    public static function loginFailed(array $params)
    {
        return new static('登录失败，用户名密码错误', 20000, [
            'params' => $params,
        ]);
    }

    public static function validateCodeSendFailed(array $params)
    {
        return new static('发送短信失败，系统错误！', 20001, [
            'params' => $params,
        ]);
    }

    public static function validateCodeNotFound(array $params)
    {
        return new static('登录失败，验证码已经失效', 20002, [
            'params' => $params,
        ]);
    }

    public static function validateCodeNotTheSame(array $params)
    {
        return new static('登录失败，验证码错误，请重新输入', 20003, [
            'params' => $params,
        ]);
    }

    public static function registerExistUser(array $params)
    {
        return new static('注册失败，您已经注册过了，请直接登录系统', 20004, [
            'params' => $params,
        ]);
    }

    public static function passwordIsNotTheSame(array $params)
    {
        return new static('注册失败，您两次输入的密码不一致', 20005, [
            'params' => $params,
        ]);
    }

    public static function userNotLogin(array $params){
        return new static('用户未登录，请登录以后重试', 20006, [
            'params' => $params,
        ]);
    }
}