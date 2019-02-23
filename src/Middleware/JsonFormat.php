<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/2/22
 * Time: 12:34 PM
 */

namespace Nichozuo\LaravelCommon\Middleware;


use Closure;
use Illuminate\Http\JsonResponse;

class JsonFormat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // 包装的外层结构
        $message = [
            'code' => 0,
            'message' => 'success',
        ];

        // 执行动作
        if ($response instanceof JsonResponse) {
            $oriData = $response->getData();
            $oriType = gettype($oriData);
            $data = array();

            if ($oriType == 'object') {

                // 如果是Exception类型的，就不用包装
                if (property_exists($oriData, 'error')) {
                    return $response;
                }

                // 如果有data,则解开data
                $data['data'] = ($oriData->data ?? []) ? $oriData->data : $oriData;

                // 处理分页
                if ($oriData->current_page ?? '') {
                    $data['meta'] = [
                        'total' => $oriData->total ?? 0,
                        'per_page' => (int)$oriData->per_page ?? 0,
                        'current_page' => $oriData->current_page ?? 0,
                        'last_page' => $oriData->last_page ?? 0
                    ];
                }

                // 处理meta下的分页
                if ($oriData->meta ?? '') {
                    $data['meta'] = [
                        'total' => $oriData->meta->total ?? 0,
                        'per_page' => (int)$oriData->meta->per_page ?? 0,
                        'current_page' => $oriData->meta->current_page ?? 0,
                        'last_page' => $oriData->meta->last_page ?? 0
                    ];
                }
            } else {
                if ($oriData == '' || $oriData == null) {
                    $oriData = false;
                } else {
                    $data['data'] = $oriData;
                }
            }

            // 合并数组
            $temp = ($oriData) ? array_merge($message, $data) : $message;
            $response = $response->setData($temp);
        }
        return $response;
    }
}