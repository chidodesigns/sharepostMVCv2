<?php

//Front Controller

/**
 * Composer
 */
// require '../vendor/autoload.php';
require dirname(__DIR__).'/config/bootstrap.php';


/**
 * Error and Exception Handling
 */

//The set_exception_handler() function sets a user-defined exception handler function.
//The script will stop executing after the exception handler is called. 
set_exception_handler('Core\Error::exceptionHandler');

 /**
 * *
 * Routing
 */

//  $router = new Core\Router();

// //Add The Routes
// $router->add('', ['controller' => 'Home', 'action' => 'index']);
// $router->add('{controller}/{action}');
// $router->add('{controller}/{id:\d+}/{action}');
// //add a route 
// $router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

// //grab url query and dispatch router to find route
// $router->dispatch($_SERVER['QUERY_STRING']);

//Displays all info about your PHP installation
// phpinfo();