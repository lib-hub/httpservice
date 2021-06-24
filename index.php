<?php /** @noinspection PhpUndefinedMethodInspection */

/**
 * Allow cross origin requests (cors)
 * replace * with ip/domain to restrict allowed clients
 */
header('Access-Control-Allow-Origin: *');

/**
 * Header of allowed HTTP methods
 */
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');

/**
 * Allow content-type header
 */
header('Access-Control-Allow-Headers: Content-Type');

/**
 * Autoload libraries and all project classes
 */
require_once 'autoload.php';

use app\App;
use components\http\Route;
use components\http\Request;
use components\http\Response;
use components\http\ResponseException;

$dotEnv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotEnv->load();

App::initialize();

$routes = Route::getInstance();
$pathData = $routes->parseCurrentPath();

try {
    if ($pathData->pathExists && $pathData->validMethod) {
        $controllerClass = "\\app\\controllers\\" . $pathData->route->controller;
        $controller = new $controllerClass;
        $request = Request::getInstance();

        switch ($request->method()) {
            case "POST":
                echo $controller->create($request)->execute();
                break;
            case "GET":
                if (isset($pathData->parameter))
                    $controller->retrieve($pathData->parameter, $request)->execute();
                else
                    $controller->index($request)->execute();
                break;
            case "PUT":
            case "PATCH":
                echo $controller->update($pathData->parameter, $request)->execute();
                break;
            case "DELETE":
                echo $controller->destroy($pathData->parameter, $request)->execute();
                break;
            default:
                (new Response([], 200))->execute();
        }
    } else {
        $message = ($pathData->pathExists) ? "Method not allowed." : "Path not found.";
        $status = ($pathData->pathExists) ? 405 : 404;
        (new Response(["message" => $message], $status))->execute();
    }
} catch (ResponseException $e) {
    http_response_code(500);
}
