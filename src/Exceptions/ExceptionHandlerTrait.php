<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/2/22
 * Time: 11:45 AM
 */

namespace Nichozuo\LaravelCommon\Exceptions;


use BadMethodCallException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Predis\Connection\ConnectionException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

trait ExceptionHandlerTrait
{
    private $data = array();
    private $msg = '';
    private $code = 0;

    /***
     * @param $request
     * @param $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderJson(Request $request, \Exception $exception)
    {
        $class = get_class($exception);

        $this->msg = $exception->getMessage();
        $this->code = (int)$exception->getCode();

        switch ($class) {
            case AuthFailedException::class:
            case ResourceException::class:
            case SendMessageFailedException::class:
            case ValidationException::class:
                $this->data = $exception->getData();
                break;
            case \Illuminate\Validation\ValidationException::class:
                $this->code = 10000;
                $this->msg = '数据校验失败';
                $this->data = array(
                    'message' => $exception->errors()
                );
                break;
            case ConnectionException::class:
                $this->code = 1;
                $this->msg = 'Redis服务器连接失败';
                $this->data = array(
                    'message' => $exception->getMessage()
                );
                break;
            case ModelNotFoundException::class:
                $this->msg = '没有找到数据';
                $this->data = array(
                    'message' => $exception->getMessage()
                );
                break;
            case QueryException::class:
                $this->msg = '操作数据错误，请重试！';
                $this->data = array(
                    'message' => $exception->getMessage(),
                    'sql' => $exception->getSql(),
                    'bindings' => $exception->getBindings()
                );
                break;
            case NotFoundHttpException::class:
                $this->msg = '没有找到路由信息';
                $this->data = array(
                    'message' => $exception->getMessage()
                );
                break;
            case MethodNotAllowedHttpException::class:
                $this->msg = '请求方式不正确';
                $this->data = array(
                    'message' => $exception->getMessage()
                );
                break;

            case UserNotDefinedException::class:
            case AuthenticationException::class:
                throw AuthFailedException::userNotLogin([
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'params' => $request->all()
                ]);
                break;
            default:
                $this->code = 9;
                $this->msg = '系统错误';
                $this->data = array(
                    'message' => $exception->getMessage(),
                    'exception' => $class
                );
                break;
        }

        $this->data['request'] = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'params' => $request->all()
        ];

        Log::error($this->msg, $this->data);

        return response()->json([
            'code' => $this->code,
            'message' => $this->msg,
            'error' => $this->data
        ]);
    }
}