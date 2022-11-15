<?php
namespace App\Controllers;

use App\Repository\UserRepository;
use App\Utilities\RoutesHelper;
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
            RoutesHelper::redirect('/');
        }else{
            View::renderTemplate('Login/login.html', [
                'email' => $_POST['email']
            ]);
        }
    }
}
