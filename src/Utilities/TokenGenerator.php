<?php

namespace App\Utilities;

class TokenGenerator
{
    /**
     * The Token Value
     * @var string
     */
    protected string $token;

    public function __construct($token_value = null)
    {
        if ($token_value) {
            $this->token = $token_value;
        } else {

            $this->token = bin2hex(random_bytes(16));
        }
    }

    /**
     * Get The Token Value
     *
     * @return void
     */
    public function getTokenValue()
    {
        return $this->token;
    }


    /**
     * Get the hashed token value
     *
     * @return string [hashed value]
     */
    public function getHash()
    {
        return hash_hmac('sha256', $this->token, $_ENV['APPSECRET']);
    }
}
