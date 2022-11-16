<?php

namespace App\Repository;

use App\Utilities\TokenGenerator;
use Core\DatabaseORM;
use ORM;

class UserRepository 
{

    public function __construct()
    {
        $this->orm = new DatabaseORM;
        $this->orm->connect();
    }

    public function findUserEmail(string $email)
    {
       
        return ORM::for_table('users')->where('email', $email)->find_one();
        
    }

    public function getId(int $userId)
    {
        $user = ORM::for_table('users')->find_one($userId);
        return $user;   
    }


}
