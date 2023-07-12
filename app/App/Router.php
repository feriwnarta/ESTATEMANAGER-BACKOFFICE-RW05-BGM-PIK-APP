<?php

namespace NextG\RwAdminApp\App;

class Router
{
    private static $routes = [];


    public static function add(string $method, string $path, string $controller, string $function, array $middleware = []): void
    {

        self::$routes[] = array(
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'function' => $function,
            'middleware' => $middleware
        );
    }


    public static function run(): void
    {
        $path = '/';


        // update path   
        if (isset($_SERVER['PATH_INFO'])) {
            $path = $_SERVER['PATH_INFO'];
        }

        // dapatkan request method
        $method = $_SERVER['REQUEST_METHOD'];


        foreach (self::$routes as $route) {


            // cocokan path dari url sesuai tidak dengan route yang sudah kita bikin
            $pattern = "#^" . $route['path'] . "$#";



            if (preg_match($pattern, $path, $mathces) && $method == $route['method']) {
                // panggil middleware terlebih dahulu sebagai interceptor
                foreach ($route['middleware'] as $middleware) {
                    $instance = new $middleware;
                    $instance->before();
                }


                // ambil function
                $function = $route['function'];

                // ambil controller
                $controller = new $route['controller'];

                array_shift($mathces);




                call_user_func_array([$controller, $function], $mathces);

                return;
            }
        }



        http_response_code(404);
        echo 'CONTROLLER NOT FOUND';
    }
}