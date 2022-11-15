<?php
namespace App\Controllers;

use App\Repository\UserRepository;
use App\Utilities\RoutesHelper;
use App\Utilities\SessionHelper;
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

        $user = $userRepo->authenticate($_POST['email'], $_POST['password']);

        if($user){

            SessionHelper::createUserSession($user);

            RoutesHelper::redirect('/');
        }else{
            View::renderTemplate('Login/login.html', [
                'email' => $_POST['email']
            ]);
        }
    }

    /**
     * Log Out A User
     * @return void
     */
    public function destroyAction() 
    {
        SessionHelper::destroyUserSession();

        RoutesHelper::redirect('/');
    }
}
