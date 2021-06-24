<?php

namespace components\http;

use stdClass;

class Request
{
    private static $instance;

    private function __construct()    {}

    /**
     * @return Request
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Request();
        }
        return self::$instance;
    }

    /**
     * @return stdClass
     */
    public function data()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Request();
        }
        $request = new stdClass();
        $request->body = self::body();
        $request->params = self::params();
        $request->method = self::method();
        $request->headers = self::headers();
        $request->env = $_ENV;
        return $request;
    }

    /**
     * @return string
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function body()
    {
        if (file_get_contents('php://input') === false) {
            return '';
        }
        return file_get_contents('php://input');
    }

    /**
     * @return array
     */
    public function params()
    {
        return $_REQUEST;
    }

    /**
     * @return array
     */
    public function headers()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) != 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    /**
     * @param $name
     * @return array|false|string
     */
    public static function getEnv($name) {
        //TODO: return one type
        return getenv($name);
    }
}