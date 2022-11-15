<?php
namespace App\Repository;

use ORM;

class UserRepository 
{
 
    public static function findUserEmail($email)
    {
        return ORM::for_table('users')->where('email', $email)->find_one();
    }
}