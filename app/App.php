<?php

namespace app;

use components\http\Route;

class App {
    public static function initialize() {
        $routes = Route::getInstance();
        $routes->addRoute("/home", "HomeController");
    }
}