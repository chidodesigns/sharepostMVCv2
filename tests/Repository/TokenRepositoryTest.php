<?php
namespace Tests\Repository;

use PHPUnit\Framework\TestCase;

class TokenRepositoryTest extends TestCase
{

    private $mockModel;
    private $token; 

    protected function setUp():void
    {
        $this->mockModel = $this->createMock(\App\Models\Token::class);
        $this->token = new $this->mockModel(1);
        $this->token->token_hash = 'c6e1f83ea5d8d5e0a791a74ef1ac350519b5de6c8ec3adfb8bd20a71f67f87f8';
        $this->token->user_id = 1;
        $this->token->expires_at = '2022-12-16 19:48:53';
        $this->token->createToken();

    }

    public function testFindByToken()
    {
        $tokenRepoMockModel = $this->createMock(\App\Repository\TokenRepository::class);

        $tokenRepo = new $tokenRepoMockModel;
        $tokenRepo->findByToken( $this->token->token_hash);

        $tokenRepo
            ->expects($this->once())
            ->method('findByToken')
            ->willReturn($this->token);

        $this->assertEquals($this->token, $tokenRepo->findByToken( $this->token->token_hash));
    }

    public function testDeleteToken()
    {
        $tokenRepoMockModel = $this->createMock(\App\Repository\TokenRepository::class);

        $tokenRepo = new $tokenRepoMockModel;

        $deletedToken = $tokenRepo->deleteToken($this->token->token_hash);

        $tokenRepo
            ->expects($this->once())
            ->method('deleteToken');

        $this->assertEmpty($deletedToken);
    }

}