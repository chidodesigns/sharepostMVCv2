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

    // public static function findUserEmail(string $email)
    // {
    //     $connection = Database::getInstance();
    //     $pdo = $connection->getPdo();
    //     $stmt = $pdo->prepare('SELECT * FROM users WHERE email LIKE ?');
    //     $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    //     $stmt->execute([$email]);
    //     $result = $stmt->fetch();
    //     return $result;
    // }

    public function findUserEmail(string $email)
    {
       
        return ORM::for_table('users')->where('email', $email)->find_one();
        ;
    }

    /**
     * Authenticate a user by email and password
     *
     * @param [string] $email
     * @param [string] $password
     * @return void
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
