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

    public static function findUserEmail(string $email)
    {
        $connection = Database::getInstance();
        $pdo = $connection->getPdo();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email LIKE ?');
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result;
    }

    public function findUserEmailORM(string $email)
    {
       
        return ORM::for_table('users')->where('email', $email)->find_one();
        ;
    }
}
