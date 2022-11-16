<?php
namespace Tests\Repository;

use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{

    private $modelMock;
    private $user;

    protected function setUp():void
    {
        $this->modelMock = $this->createMock(\App\Models\User::class);
        $this->user = new $this->modelMock;
        $this->user->setFirstname('jane');
        $this->user->setLastname('Doe');
        $this->user->setEmail('janedoe@example.com');
        $this->user->setPlainPassword('123Registration');
        $this->user->create();

    }

    public function testFindUserEmail()
    {
        $userRepoMockModel = $this->createMock(\App\Repository\UserRepository::class);

        $userRepo = new $userRepoMockModel;
        $userRepo->findUserEmail('janedoe@example.com');

        $userRepo
        ->expects($this->once())
        ->method('findUserEmail')
        ->willReturn($this->user);

        $this->assertEquals($this->user, $userRepo->findUserEmail('janedoe@example.com'));
    }

    public function testGetId()
    {
        $userRepoMockModel = $this->createMock(\App\Repository\UserRepository::class);

        $userRepo = new $userRepoMockModel;
        $userRepo->getId(1);

        $userRepo
        ->expects($this->once())
        ->method('getId')
        ->willReturn($this->user);

        $this->assertEquals($this->user, $userRepo->getId(1));
    }

}