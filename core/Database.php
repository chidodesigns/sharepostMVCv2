<?php

namespace Core;

use PDO;

class Database
{
    private static ?self $insance = null;
    private \PDO $pdo;

    private $host =  'mariadb';
    private $user = 'shareposts_user';
    private $pass = 't]a03p?/OfWk';
    private $dbname = 'shareposts';
    private $charset = 'utf8mb4';

    private const OPTIONS = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ];

    private function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        try{
            $this->pdo = new \PDO($dsn, $this->user, $this->pass, self::OPTIONS);
        }catch(\PDOException $exception){
            throw new \PDOException($exception->getMessage(), (int) $exception->getCode());
        }
    }

    public static function getInstance (): self
    {
        if(self::$insance === null){
            self::$insance = new self();
        }

        return self::$insance;
    }

    public function getPdo():?PDO
    {
        return $this->pdo;
    }

}