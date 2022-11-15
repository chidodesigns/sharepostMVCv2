<?php

namespace App\Models;

use Core\DatabaseORM;
use ORM;

class User extends DatabaseORM
{

    /**
     * @var [string]
     */
    public string $firstname;

    /**
     * @var [string]
     */
    public string $lastname;

    /**
     * @var [string]
     */
    public $email;

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
        $user =  ORM::for_table('users')->where('firstname', $this->firstname)->find_one();
        $user->set('firstname', $firstname);
        return $this;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname):self
    {
        $user =  ORM::for_table('users')->where('lastname', $this->lastname)->find_one();
        $user->set('lastname', $lastname);
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email):self
    {
        $user = ORM::for_table('users')->where('email', $email)->find_one();
        $user->set('email', $email);
        return $this;
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
        $user->password = password_hash($this->password, PASSWORD_DEFAULT);

        $user->save();

        return $user;
    }

}
