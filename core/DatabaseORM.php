<?php

namespace Core;

use ORM;

 class DatabaseORM
{


    private $host =  'mariadb';
    private $user = 'shareposts_user';
    private $pass = 't]a03p?/OfWk';
    private $dbname = 'shareposts';

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            ORM::configure("mysql:host={$this->host};dbname={$this->dbname}");
            ORM::configure('username', $this->user);
            ORM::configure('password', $this->pass);
        } catch(\Exception $exception){
            throw new \Exception($exception->getMessage(), (int) $exception->getCode());
        }
     
    }
}