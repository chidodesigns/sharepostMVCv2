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

}
