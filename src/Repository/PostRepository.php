<?php
namespace App\Repository;

use Core\DatabaseORM;
use ORM;

class PostRepository 
{
    public function getAllPosts()
    {
        DatabaseORM::connect();
        return ORM::for_table('posts')->find_many();
    }
}