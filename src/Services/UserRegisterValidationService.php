<?php

namespace App\Services;

use App\Repository\UserRepository;

class UserRegisterValidationService
{

    public array $validationErrors;

    public function validateUserRegistration(array $userRegData)
    {
        if (empty($userRegData['email'])) {
            $userRegData['email_err'] = 'Please enter email';
        } else {
            //Check email
            if (UserRepository::findUserEmail($userRegData['email'])) {
                $userRegData['email_err'] = 'Email is already taken';
            }
        }

        if (empty($userRegData['firstname'])) {
            $userRegData['firstname_err'] = 'Please enter firstname';
        }

        if (empty($userRegData['lastname'])) {
            $userRegData['lastname_err'] = 'Please enter lastname';
        }

        if (empty($userRegData['confirm_password'])) {
            $userRegData['confirm_password_err'] = 'Please confirm password';
        } else {
            if ($userRegData['password'] != $userRegData['confirm_password']) {
                $userRegData['confirm_password_err'] = 'Passwords do not match';
            }
        }

        if (empty($userRegData['email_err']) && empty($userRegData['firstname_err']) && empty($userRegData['lastname_err'])  && empty($userRegData['password_err']) && empty($userRegData['confirm_password_err'])) {

            return true;
        }else{
            $this->validationErrors = $userRegData;
            return false;
        }
    }
}
