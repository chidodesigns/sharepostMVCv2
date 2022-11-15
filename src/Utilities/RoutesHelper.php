<?php
namespace App\Utilities;

class RoutesHelper
{
    public static function redirect (string $location)
    {
        header('Location: http://' .  $_SERVER['HTTP_HOST'] . $location, true, 303);
        exit;
    }
}