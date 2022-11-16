<?php
namespace App\Models;

use App\Utilities\TokenGenerator;
use Core\DatabaseORM;
use ORM;

class Token extends DatabaseORM
{
    private TokenGenerator $tokenGenerator;
    private string $token_hash;
    private int $user_id;
    private string $expires_at;

    public function __construct(int $userId)
    {
        parent::__construct();
        $this->user_id = $userId;
        $this->tokenGenerator = new TokenGenerator();
        $this->token_hash = $this->tokenGenerator->getHash();
        $this->expires_at = time() + 60 * 60 * 24 * 30;

    }


    /**
     * See if the Token has expired or not, based on current system time
     *
     * @return boolean True if the token has expired, false otherwise
     */
    public function checkTokenExpired()
    {
        return strtotime($this->expires_at) < time();
    }


    /**
     * Create A User Login Token
     *
     * @return ORM;
     */
    public function createToken()
    {
        $token = ORM::for_table('tokens')->create();
        $token->token_hash = $this->token_hash;
        $token->user_id = $this->user_id;
        $token->expires_at = date('Y-m-d H:i:s', $this->expires_at);
        $token->save();
        return $token;
    }

    /**
     * Delete Token
     *
     * @return void
     */
    public function deleteToken()
    {
       $token = ORM::for_table('tokens')->where('token_hash', $this->token_hash)->find_one();

       $token->delete();
    }

}