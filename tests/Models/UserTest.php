<?php

namespace Tests\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    protected function setUp():void
    {
        $this->user = new User;
    }

    public function testFirstnameGetterSetterFn()
    {
        $this->user->setFirstname('John');
        $this->assertEquals('John', $this->user->getFirstname());
    }


    public function testLastnameGetterSetterFn()
    {
        $this->user->setLastname('Doe');
        $this->assertEquals('Doe', $this->user->getLastname());
    }

    public function testEmailGetterSetterFn()
    {
        $this->user->setEmail('johndoe@example.com');
        $this->assertEquals('johndoe@example.com', $this->user->getEmail());
    }

    public function testCreateUser()
    {
        $userModel = $this->createMock(\App\Models\User::class);
        
        $user = new $userModel;
        $user->setFirstname('jane');
        $user->setLastname('Doe');
        $user->setEmail('janedoe@example.com');
        $user->setPlainPassword('123Registration');
        $user->create();
       
        $user
        ->expects($this->once())
        ->method('create')
        ->willReturn($user);


        $this->assertEquals($user, $user->create());
    }
    


}
