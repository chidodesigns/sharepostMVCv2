<?php

use Core\Error;
use Core\Router;

$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');

try {
    $router->dispatch($_SERVER['QUERY_STRING']);
} catch (\Throwable $th) {
    Error::exceptionHandler($th);
}
