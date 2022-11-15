<?php

namespace App\Repository;

use Core\Database;
use Core\DatabaseORM;
use ORM;
use PDO;

class UserRepository 
{

    public function __construct()
    {
        $this->orm = new DatabaseORM;
        $this->orm->connect();
    }

    public function findUserEmail(string $email):ORM
    {
       
        return ORM::for_table('users')->where('email', $email)->find_one();
        
    }

    //  @TODO Move This To User Manager Service

    /**
     * Authenticate a user by email and password
     *
     * @param [string] $email
     * @param [string] $password
     */
    public function authenticate(string $email, string $password)
    {
        $user = $this->findUserEmail($email);

        if($user){
            if(password_verify($password, $user->password)){
                return $user;
            }
        }

        return false;

    }
}
