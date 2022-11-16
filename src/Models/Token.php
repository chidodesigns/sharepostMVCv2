<?php
namespace App\Models;

use App\Utilities\TokenGenerator;
use Core\DatabaseORM;
use DateTime;
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

}