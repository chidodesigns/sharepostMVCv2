<?php 
namespace App\Services;

use App\Repository\UserRepository;
use ORM;

class UserAuthentication
{

     /**
     * Authenticate a user by email and password
     *
     * @param [string] $email
     * @param [string] $password
     */
    public static function authenticate(string $email, string $password)
    {
        $userRepository = new UserRepository();

        $user = $userRepository->findUserEmail($email);

        if($user){
            if(password_verify($password, $user->password)){
                return $user;
            }
        }

        return false;

    }


    public static function createUserSession(ORM $user)
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
    }

    public static function destroyUserSession()
    {
        $_SESSION = [];

        if(ini_get('session.use_cookies')){
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly'],

            );

        }

        session_destroy();
    }
}