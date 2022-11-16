<?php 
namespace App\Utilities;

class PasswordGenerator
{
    public static function hashPassword ($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}