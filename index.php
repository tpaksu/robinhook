<?php

use Tpaksu\Robinhook\Robinhook;

require_once __DIR__ . '/vendor/autoload.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$router = new League\Route\Router;
$robinhook = new Robinhook($router);
$robinhook->initRoutes();

$response = $robinhook->router->dispatch($request);
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
