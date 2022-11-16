<?php

namespace Core;

use ORM;

 class DatabaseORM
{

    public function __construct()
    {
        $this->connect();
    }

    public static function connect()
    {
        try {
            ORM::configure("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}");
            ORM::configure('username', $_ENV['DB_USER']);
            ORM::configure('password', $_ENV['DB_PASSWORD']);
        } catch(\Exception $exception){
            throw new \Exception($exception->getMessage(), (int) $exception->getCode());
        }
     
    }
}