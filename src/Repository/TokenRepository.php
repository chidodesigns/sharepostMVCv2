<?php

namespace App\Repository;

use App\Utilities\TokenGenerator;
use Core\DatabaseORM;
use ORM;

class TokenRepository extends DatabaseORM
{
    public function __construct()
    {
        $this->orm = new DatabaseORM;
        $this->orm->connect();
    }

    /**
     * Find a user login token from database
     *
     * @param [string] $token
     * @return mixed Remembered login object if found. false if otherwise
     */
    public function findByToken($token_hash)
    {
        return ORM::for_table('tokens')->where('token_hash', $token_hash)->find_one();
    }

    /**
     * Delete Token
     *
     * @return void
     */
    public function deleteToken($token_hash)
    {
        $token = ORM::for_table('tokens')->where('token_hash', $token_hash)->find_one();

        $token->delete();
    }
}
