<?php

namespace App\Repository;

use App\Utilities\TokenGenerator;
use Core\DatabaseORM;
use ORM;

class UserRepository 
{

    public function __construct()
    {
        $this->orm = new DatabaseORM;
        $this->orm->connect();
    }

    public function findUserEmail(string $email)
    {
       
        return ORM::for_table('users')->where('email', $email)->find_one();
        
    }

    public function getId(int $userId)
    {
        $user = ORM::for_table('users')->find_one($userId);
        return $user;   
    }

    public function rememberLogin(int $userId)
    {
        $token = new TokenGenerator();
        $hashed_token = $token->getHash();
        $expiry_timestamp = time() + 60 * 60 * 24 * 30;

        $token = ORM::for_table('tokens')->create();
        $token->token_hash = $hashed_token;
        $token->user_id = $userId;
        $token->expires_at = date('Y-m-d H:i:s', $expiry_timestamp);
        $token->save();
    }


}
