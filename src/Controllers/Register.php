<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\UserRegisterValidationService;
use App\Utilities\RoutesHelper;
use Core\Controller;
use Core\View;

class Register extends Controller
{
    /**
     * Show Register Page
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Register/register.html');
    }

    /**
     *  Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            View::renderTemplate('500.html');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
            'firstname' => trim($_POST['firstname']),
            'lastname' => trim($_POST['lastname']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'firstname_err' => '',
            'lastname_err' => '',
            'email_err' => '',
            'password_err ' => '',
            'confirm_password_err' => ''
        ];

        $regValidService = new UserRegisterValidationService();

        $isRegValid = $regValidService->validateUserRegistration($data);

        if (!$isRegValid) {
            // var_dump($regValidService->validationErrors);
            return
                View::renderTemplate('Register/register.html', [
                    'errors' => $regValidService->validationErrors,
                    'user' => $data
                ]);
        }

        if ($isRegValid) {
            $user = new User();
            $user->firstname = $_POST['firstname'];
            $user->lastname = $_POST['lastname'];
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
            $user->create();
            RoutesHelper::redirect('/register/success');
            // View::renderTemplate('Register/success.html');
        }
    }

    /**
     * Show the register success page
     */
    public function successAction()
    {
        View::renderTemplate('Register/success.html');
    }
}
