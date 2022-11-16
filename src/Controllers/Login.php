<?php
namespace App\Controllers;

use App\Repository\UserRepository;
use App\Services\FlashMessageService;
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
        $userAuthentication = new UserAuthentication();

        $user = $userAuthentication->authenticate($_POST['email'], $_POST['password']);

        $remember_me = isset($_POST['remember_me']);


        if($user){

            $userAuthentication->loginSession($user, $remember_me);

            FlashMessageService::addMessage('Login Successful');

            $this->redirect(UserAuthentication::getReturnToPage());
        }else{

            FlashMessageService::addMessage('Login unsuccessful, please try again', FlashMessageService::DANGER);

            View::renderTemplate('Login/login.html', [
                'email' => $_POST['email'],
                'remember_me' => $remember_me
            ]);
        }
    }

    /**
     * Log Out A User
     * @return void
     */
    public function destroyAction() 
    {
        $userAuthentication = new UserAuthentication();
        $userAuthentication->destroyUserSession();

        $this->redirect('/login/show-logout-message');

    }

    /**
     * Show a 'logged out' flash message and redirect to the homepage
     *
     * @return void
     */
    public function showLogoutMessageAction()
    {

        FlashMessageService::addMessage('Logout Successful');

        $this->redirect('/');

    }
}
