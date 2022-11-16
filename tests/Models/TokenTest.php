<?php

namespace Tests\Models;

use App\Models\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    private $token;
    private $tokenMockModel;
    private $user_id = 1;

    protected function setUp(): void
    {
        $this->token = new Token($this->user_id);
        $this->tokenMockModel = $this->createMock(\App\Models\Token::class);
    }

    public function testCheckIfTokenHasExpiredFnWorks()
    {
        $hasTokenExpired = $this->token->checkTokenExpired();
        $this->assertTrue($hasTokenExpired);
    }

    public function testCreateToken()
    {
        $token = new $this->tokenMockModel($this->user_id);
        $token->token_hash = 'c6e1f83ea5d8d5e0a791a74ef1ac350519b5de6c8ec3adfb8bd20a71f67f87f8';
        $token->user_id = $this->user_id;
        $token->expires_at = '2022-12-16 19:48:53';
        $token->createToken();

        $token
            ->expects($this->once())
            ->method('createToken')
            ->willReturn($token);

        $this->assertEquals($token, $token->createToken());
    }
}
