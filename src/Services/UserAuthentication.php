<?php 
namespace App\Services;

use ORM;

class UserAuthentication
{
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