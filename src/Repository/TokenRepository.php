<?php
namespace App\Repository;

use App\Utilities\TokenGenerator;
use Core\DatabaseORM;
use ORM;

class TokenRepository extends DatabaseORM
{
     /**
     * Find a user login token from database
     *
     * @param [string] $token
     * @return mixed Remembered login object if found. false if otherwise
     */
    public static function findByToken($token)
    {
        $token = new TokenGenerator($token);
        $token_hash = $token->getHash();

        return ORM::for_table('tokens')->where('token_hash', $token_hash)->find_one();
        
    }

}