<?php

ini_set('session.cookie_lifetime', '864000');

/**
 * Sessions
 */
session_start();

//Front Controller
require dirname(__DIR__).'/config/bootstrap.php';


/**
 * Error and Exception Handling
 */
error_reporting(E_ALL);
set_error_handler("Core\Error::errorHandler");
set_exception_handler("Core\Error::exceptionHandler");


 