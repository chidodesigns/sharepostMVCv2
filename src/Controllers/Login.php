<?php
namespace App\Controllers;

use App\Repository\UserRepository;
use Core\Controller;
use Core\View;

class Login extends Controller
{
    public function newAction()
    {
        View::renderTemplate('Login/login.html');
    }

    /**
     * Log In User
     *
     * @return void
     */
    public function createAction()
    {
        $userRepo = new UserRepository();
        $user = $userRepo->findUserEmailORM($_POST['email']);

        dd($user);
    }
}
