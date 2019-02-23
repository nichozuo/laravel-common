<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/1/17
 * Time: 5:38 PM
 */

namespace Nichozuo\LaravelCommon\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseJsonResource extends JsonResource
{
    protected function getActionName(Request $request)
    {
        $action_name = $request->route()->getActionName();
        return explode('@', $action_name)[1];
    }
}