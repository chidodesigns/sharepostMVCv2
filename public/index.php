<?php

//Front Controller
require dirname(__DIR__).'/config/bootstrap.php';


/**
 * Error and Exception Handling
 */
set_exception_handler('Core\Error::exceptionHandler');

