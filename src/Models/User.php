<?php

namespace App\Models;

use App\Utilities\PasswordGenerator;
use Core\DatabaseORM;
use ORM;

class User 
{

    /**
     * @var [string]
     */
    private string $firstname;

    /**
     * @var [string]
     */
    private string $lastname;

    /**
     * @var [string]
     */
    private $email;

    /**
     *
     * @var [string]
     */
    private $plainPassword;

    /**
     * @var [string]
     */
    public $password;

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname):self
    {
       
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname):self
    {
       
        $this->lastname = $lastname;
        
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email):self
    {
      
        $this->email = $email;
        
        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword):self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

 
    /**
     * Create and Save user model with the current property values
     * @return ORM
     */
    public function create()
    {
        DatabaseORM::connect();
        $user = ORM::for_table('users')->create();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->password = PasswordGenerator::hashPassword($this->plainPassword);

        $user->save();

        return $user;
    }

}
