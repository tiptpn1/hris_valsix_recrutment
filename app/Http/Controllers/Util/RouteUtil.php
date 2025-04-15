<?php

namespace App\Http\Controllers\Util;

use Illuminate\Support\Facades\DB;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflection\ReflectionMethod;

class RouteUtil {

    public static function getRouteFromController($path, $method = 'route_web') {
        $path = app_path() . $path;
        $allFiles = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path)
        );
        $ctrlFiles = new \RegexIterator($allFiles, '/\.php$/');
        foreach ($ctrlFiles as $pathname => $fileinfo) {
            if (!$fileinfo->isFile()) continue;

            $str = '';
            if (substr($pathname, 0, strlen(app_path())) == app_path()) {
                $str = substr($pathname, strlen(app_path()));
            }

            if (substr($str, -strlen('.php')) === '.php') {
                $str = substr($str, 0, -strlen('.php'));
            }
            $str = 'App' . str_replace('/', '\\', $str);

            try {
                $r = new \ReflectionClass($str);
                $instance = $r->newInstanceWithoutConstructor();
                if (method_exists($instance, $method)) {
                    $instance->{$method}();
                }
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

}