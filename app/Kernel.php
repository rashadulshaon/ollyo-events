<?php

namespace App;

class Kernel
{
    private const DEBUG = true;
    private Container $container;

    public function __construct()
    {
        try {
            $this->container = new Container();
            $this->handleRequest();
        } catch (\Exception $e) {
            if (self::DEBUG) {
                echo $e->getMessage();
            } else {
                echo 'An error occurred. Please try again later.';
            }
        }
    }

    private function handleRequest()
    {
        $router = $this->container->get(Router::class);
        $router->registerRoutesFromNamespace('App\Processor');

        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        try {
            echo $router->dispatch($requestUri, $requestMethod);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
