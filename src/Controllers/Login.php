<?php
namespace App\Controllers;

use App\Services\UserAuthentication;
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
        
        $user = UserAuthentication::authenticate($_POST['email'], $_POST['password']);

        if($user){

            UserAuthentication::createUserSession($user);

            $this->redirect('/');
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
        UserAuthentication::destroyUserSession();

        $this->redirect('/');
    }
}
