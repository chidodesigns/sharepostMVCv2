<?php

namespace App\Repository;

use Core\Database;

class UserRepository 
{

    private $connection;
    public $pdo;

    public function __construct()
    {
        $this->connection = Database::getInstance();
        $this->pdo = $this->connection->getPdo();
    }
   
    public function findUserEmail(string $email)
    {
      
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email LIKE ?');
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result;
    }
}
