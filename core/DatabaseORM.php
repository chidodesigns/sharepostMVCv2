<?php

namespace Core;

use ORM;

abstract class DatabaseORM
{


    private $host =  'mariadb';
    private $user = 'shareposts_user';
    private $pass = 't]a03p?/OfWk';
    private $dbname = 'shareposts';

    public function __construct()
    {
        try{
            ORM::configure("mysql:host={$this->host};dbname={$this->dbname}");
            ORM::configure('username', $this->user);
            ORM::configure('password', $this->pass);
        }catch(\Exception $exception){
            throw new \Exception($exception->getMessage(), (int) $exception->getCode());
        }

    }
}