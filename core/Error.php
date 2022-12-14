<?php

namespace Core;

/**
 * Error and exception handler
 * 
 */

class Error
{

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException
     *
     * @param [int] $level
     * @param [string] $message
     * @param [string] $file
     * @param [int] $line
     * @return void
     */
    public static function errorHandler(int $level, string $message, string $file, int $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }


    /**
     * Exception Handler
     *
     * @param Exception $exception The exception
     *
     * @return void
     */

    public static function exceptionHandler($exception)
    {

        $code  = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        if ($_ENV['APP_DEBUG']) {

            echo "<h1>Fatal Error</h1>";
            echo "<p>Uncaught exception: ' " . get_class($exception) . " '</p> ";
            echo "<p>Message: ' " . $exception->getMessage() . " '</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {

            $log = dirname(__DIR__) . '/' . 'logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);

            $message = "Uncaught exception: ' " . get_class($exception) . " ' ";
            $message .= " with message ' " . $exception->getMessage() . " ' ";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in ' " . $exception->getFile() . " ' on line " . $exception->getLine();

            error_log($message);
            View::renderTemplate("$code.html");
        }
    }
}
