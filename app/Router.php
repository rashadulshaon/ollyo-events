<?php

namespace App;

use App\Attributes\Route;
use App\Service\ClassFinder;

/**
 * Class Router
 *
 * Manages routing of HTTP requests to processor methods based on defined routes.
 * Supports attribute-based routing and URL parameter matching.
 *
 * @package App
 * @author Rashadul Shaon <codershaon@gmail.com>
 * @date 2025-01-23
 * @version 1.0
 * @link https://shaon.pages.dev
 */
class Router
{
    private array $routes = [];
    private array $processors = [];

    public function __construct(private ClassFinder $classFinder) {}

    public function registerRoutesFromNamespace(string $namespace)
    {
        $processorClasses = $this->classFinder->getClassesUnderNamespace($namespace);

        foreach ($processorClasses as $class) {
            if (strpos($class, $namespace) === 0) {
                $this->registerRoutes(new $class());
            }
        }
    }

    private function registerRoutes(object $processor)
    {
        $processorClass = new \ReflectionClass($processor);
        $this->processors[$processorClass->getName()] = $processor;

        foreach ($processorClass->getMethods() as $method) {
            $attributes = $method->getAttributes(Route::class);
            foreach ($attributes as $attribute) {
                $route = $attribute->newInstance();
                $this->routes[$route->method][$route->path] = $method;
            }
        }
    }

    public function match(string $url, string $requestMethod)
    {
        if (!isset($this->routes[$requestMethod])) {
            return null;
        }

        foreach ($this->routes[$requestMethod] as $path => $method) {
            $pattern = preg_replace('/{(\w+)}/', '(?P<$1>[^/]+)', $path);
            if (preg_match("#^$pattern$#", $url, $matches)) {
                return [$method, $matches];
            }
        }

        return null;
    }

    public function dispatch(string $url, string $requestMethod)
    {
        $result = $this->match($url, $requestMethod);
        if ($result) {
            [$method, $params] = $result;
            $processorClass = $method->getDeclaringClass()->getName();
            $processor = $this->processors[$processorClass];
            return $method->invokeArgs($processor, $this->resolveParams($method, $params));
        }

        http_response_code(404);

        throw new \Exception("No route found for URL: $url with method: $requestMethod");
    }

    private function resolveParams(\ReflectionMethod $method, array $params): array
    {
        $resolvedParams = [];
        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();
            if (isset($params[$name])) {
                $resolvedParams[] = $params[$name];
            } else {
                $resolvedParams[] = null;
            }
        }
        return $resolvedParams;
    }
}
