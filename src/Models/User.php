<?php

namespace App\Models;

use Core\DatabaseORM;
use ORM;

class User extends DatabaseORM
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

    /**
     * Class Constructor
     * @param array $data Initial Prop Values
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

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
    public function create():ORM
    {

        $user = ORM::for_table('users')->create();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->password = password_hash($this->plainPassword, PASSWORD_DEFAULT);

        $user->save();

        return $user;
    }

}
