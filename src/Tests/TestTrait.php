<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 3:33 PM
 */

namespace Nichozuo\LaravelCommon\Tests;


use Illuminate\Support\Facades\Cache;

trait TestTrait
{
    protected $base_url = '';
    protected $auth_guard = 'admin';
    protected $debug = true;

    protected function go($url, $params = array(), $method = 'POST')
    {
        // 如果需要id，又没传id，就从缓存取
        if (in_array($url, ['show', 'update', 'destroy']) && !array_key_exists('id', $params)) {
            $params['id'] = (int)Cache::tags('test')->get('id');
        }

        // 请求接口
        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->get_jwt_token()])
            ->json($method, $this->base_url . $url, $params);

        if (!$this->debug) {
            $response
                ->assertJsonStructure([
                    'code',
                    'msg',
                    'data'
                ])
                ->assertJson([
                    'code' => 1,
                    'msg' => 'ok'
                ]);
        } else {
            $this->assertTrue(true);
        }

        // 输出接口内容
        $data = json_decode($response->content());
        echo $this->base_url . $url;
        echo PHP_EOL;
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        echo PHP_EOL;
        echo PHP_EOL;

        // 如果是store，则存储id到缓存中
        if ($url == 'store') {
            Cache::tags('test')->put('id', $data->data->id, 5);
        }

        // 如果是login，则存储token到缓存中
        if ($url == 'login' || $url == 'refresh') {
            Cache::tags('test')->forever($this->auth_guard, $data->data->access_token);
        }

        if ($url == 'logout') {
            Cache::tags('test')->forget($this->auth_guard);
        }
    }

    private function get_jwt_token()
    {
        return Cache::tags('test')->get($this->auth_guard);
    }

    protected function getSequentialArray($count)
    {
        $arr = array();
        for ($i = 0; $i < $count; $i++) {
            $arr[$i] = $i + 1;
        }
        return $arr;
    }
}