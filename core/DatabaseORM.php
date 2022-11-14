<?php

namespace Core;

use ORM;

class DatabaseORM
{
    private static ?self $insance = null;

    private $host =  DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $charset = DB_CHARSET;

    private function __construct()
    {
    
        try{
            ORM::configure("mysql:host={$this->host};dbname={$this->dbname}");
            ORM::configure('username', $this->user);
            ORM::configure('password', $this->pass);
        }catch(\Exception $exception){
            throw new \Exception($exception->getMessage(), (int) $exception->getCode());
        }

    }

    public static function getInstance (): self
    {
        if(self::$insance === null){
            self::$insance = new self();
        }

        return self::$insance;
    }

}