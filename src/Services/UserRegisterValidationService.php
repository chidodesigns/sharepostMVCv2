<?php

namespace App\Services;

use App\Repository\UserRepository;

class UserRegisterValidationService
{

    public array $validationErrors = [];
    public $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function validateUserRegistration(array $userRegData)
    {

        if (empty($userRegData['firstname'])) {
            $this->validationErrors['firstname_err'] = 'Please enter firstname';
        }

        if (empty($userRegData['lastname'])) {
            $this->validationErrors['lastname_err'] = 'Please enter lastname';
        }

        if (empty($userRegData['email'])) {
            $this->validationErrors['email_err'] = 'Please enter email';
        }elseif(filter_var($userRegData['email']) === false){
            $this->validationErrors['email_err'] = 'Invalid email';
        } 
        else {
            //Check email
            if ($this->userRepo->findUserEmail($userRegData['email'])) {
                $this->validationErrors['email_err'] = 'Email is already taken';
            }
        }

        if(empty($userRegData['password'])){
            $this->validationErrors['password_err'] = 'Please enter password';
          } elseif(strlen($userRegData['password']) < 6){
            $this->validationErrors['password_err'] = 'Password must be at least 6 characters';
          }

          if(preg_match('/.*[a-z]+.*/i', $userRegData['password'] == 0)){
            $this->validationErrors['password_err'] = 'Passwords needs at least one letter';
          }

          if(preg_match('/.*\d+.*/i', $userRegData['password'] == 0)){
            $this->validationErrors['password_err'] = 'Password needs at least one letter';
          }

        if (empty($userRegData['confirm_password'])) {
            $this->validationErrors['confirm_password_err'] = 'Please confirm password';
        } else {
            if ($userRegData['password'] != $userRegData['confirm_password']) {
                $this->validationErrors['confirm_password_err'] = 'Passwords do not match';
            }
        }

        if (empty($this->validationErrors['email_err']) && empty($this->validationErrors['firstname_err']) && empty($this->validationErrors['lastname_err'])  && empty($this->validationErrors['password_err']) && empty($this->validationErrors['confirm_password_err'])) {

            return true;
        }else{
            
            return false;
        }
    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
