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

    public static function newRoute($router, $controller, array $actions, $prefix = null)
    {
        $controller = (str_start($controller, '\\')) ? $controller : '\\' . $controller;

        foreach ($actions as $action) {

            $temp = explode($action, ':');

            $method = (count($temp) == 2) ? [$temp[0]] : ['get'];
            $actionName = (count($temp) == 2) ? $temp[1] : $temp[0];

            $URI = ($prefix == null) ? snake_case($actionName) : $prefix . '/' . snake_case($actionName);

            $routerName = ($prefix == null) ? snake_case($actionName) : implode(explode('/', $prefix), '.') . '.' . snake_case($actionName);

            $router->match($method, $URI, $controller . '@' . $actionName)->name($routerName);
        }
    }
}