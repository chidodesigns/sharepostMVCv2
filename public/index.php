<?php

//Front Controller
require dirname(__DIR__).'/config/bootstrap.php';


/**
 * Error and Exception Handling
 */
error_reporting(E_ALL);
// @TODO Check this line of code - currently producing error
// set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

