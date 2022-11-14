<?php

namespace Core;

use PDO;

class Database
{
    private static ?self $insance = null;
    private \PDO $pdo;

    private $host =  DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $charset = DB_CHARSET;

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