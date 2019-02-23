<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 10:54 PM
 */

namespace Nichozuo\LaravelCommon\Resources;


trait ResourceTrait
{
    protected function parcel($data)
    {
        return [
            'code' => 1,
            'msg' => 'ok',
            'data' => $data
        ];
    }
}