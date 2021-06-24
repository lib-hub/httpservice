<?php

namespace components\http;

use stdClass;
use components\Url;

class Route
{
    private static $instance;
    private static $routes;
    private $request;

    private function __construct()
    {
        $this->request = Request::getInstance();
    }

    /**
     * @return Route
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Route();
            self::$routes = [];
        }

        return self::$instance;
    }

    /**
     * @param $path
     * @param $controller
     */
    public function addRoute($path, $controller)
    {
        if (class_exists("\\app\\controllers\\" . $controller)) {
            $route = new stdClass();
            $route->path = $path;
            $route->controller = $controller;
            self::$routes[$path] = $route;
        } else {
            throw new RouteException('Controller not found');
        }
    }

    /**
     * @return stdClass
     */
    public function parseCurrentPath()
    {
        $data = new stdClass();
        $data->pathExists = true;
        $data->validMethod = ($this->request->method() === 'OPTIONS');
        $currentPath = Url::getCurrentPath();
        $currentPathNoParam = Url::getCurrentPathWithoutLastComponent();

        if (array_key_exists($currentPath, self::$routes)) {
            $data->route = self::$routes[$currentPath];

            if ($this->request->method() === 'POST' || $this->request->method() === 'GET') {
                $data->validMethod = true;
            }
        } elseif (array_key_exists($currentPathNoParam, self::$routes)) {
            $data->parameter = ltrim(Url::getCurrentPathLastComponent(), '/');
            $data->route = self::$routes[$currentPath];

            if ($this->request->method() === 'GET' ||
                $this->request->method() === 'PUT' ||
                $this->request->method() === 'PATCH' ||
                $this->request->method() === 'DELETE') {
                $data->validMethod = true;
            }
        } else {
            $data->pathExists = false;
        }

        return $data;
    }

    /**
     * @param $path
     * @return object
     */
    public function getRoute($path)
    {
        return self::$routes[$path];
    }

    /**
     * Get all the paths that have been set
     *
     * @return array of string
     */
    public function getPaths()
    {
        $tempArray = [];

        foreach (self::$routes as $path => $route) {
            $tempArray[] = $path;
        }

        return $tempArray;
    }

    /**
     * Get all the routes that have been set
     *
     * @return array of object
     */
    public function getRoutes()
    {
        $tempArray = [];

        foreach (self::$routes as $path => $route) {
            $tempArray[] = $route;
        }

        return $tempArray;
    }
}