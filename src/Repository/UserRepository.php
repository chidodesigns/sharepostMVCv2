<?php

namespace App\Repository;

use Core\DatabaseORM;
use ORM;

class UserRepository 
{

    public function __construct()
    {
        $this->orm = new DatabaseORM;
        $this->orm->connect();
    }

    /**
     * Find A User By Email In ORM
     *
     * @param string $email
     * @return mixed ORM User Object or false
     */
    public function findUserEmail(string $email)
    {
       
        return ORM::for_table('users')->where('email', $email)->find_one();
        
    }

    /**
     * Get User By Id
     *
     * @param integer $userId
     * @return mixed ORM User Object or false
     */
    public function getId(int $userId)
    {
        $user = ORM::for_table('users')->find_one($userId);
        return $user;   
    }


}
