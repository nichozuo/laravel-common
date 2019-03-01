<?php
/**
 * Created by PhpStorm.
 * User: zuowenbo
 * Date: 2019/2/1
 * Time: 6:00 PM
 */

namespace Nichozuo\LaravelCommon\Routes;

use Illuminate\Support\Str;

class RouteHelper
{
    public static function registerRoute($controllerName, array $actionsName, $router, $prefix = null)
    {
        foreach ($actionsName as $name) {
            $snake_name = Str::snake($name);
            if ($prefix == null) {
                $router->post($snake_name, $controllerName . '@' . $name)->name($name);
            } else {
                $router->post($prefix . '/' . $snake_name, $controllerName . '@' . $name)->name($prefix . '.' . $name);
            }
        }
    }
}