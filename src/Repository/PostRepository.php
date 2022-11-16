<?php
namespace App\Repository;

use Core\DatabaseORM;
use ORM;

class PostRepository 
{
    public function __construct()
    {
        $this->orm = new DatabaseORM;
        $this->orm->connect();
    }

    public function getAllPosts()
    {
        return ORM::for_table('posts')->find_many();
    }
}