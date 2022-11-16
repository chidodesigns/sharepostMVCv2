<?php

namespace App\Services;

use App\Models\Token;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use ORM;

class UserAuthentication
{

    /**
     * @var ORM
     */
    private $user;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    /**
     * Authenticate a user by email and password
     *
     * @param [string] $email
     * @param [string] $password
     */
    public function authenticate(string $email, string $password)
    {
        $this->user = $this->userRepository->findUserEmail($email);

        if ($this->user) {
            if (password_verify($password, $this->user->password)) {
                return $this->user;
            }
        }

        return false;
    }

    /**
     * Undocumented function
     *
     * @param ORM $user User Model ORM Version
     * @param [boolean] $remember_me Remember the login if true
     * @return void
     */
    public function loginSession(ORM $user, $remember_me)
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;

        $token = new Token($user->id);
        $newToken = $token->createToken();

        if ($remember_me) {
            setcookie(
                'remember_me',
                $newToken->token_hash,
                time() + 60 * 60 * 24 * 30,
                '/'
            );
        }
    }

    public static function destroyUserSession()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
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

    /**
     * Return indicator of whether a user is logged in or not
     * @return boolean
     */

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Remember the originally-requested page in the session
     * @return void
     */
    public static function rememberRequestedPage()
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }

    /**
     * Get the originally requested page to return to after requiring login, or default to the homepage
     * @return void
     */
    public static function getReturnToPage()
    {
        return $_SESSION['return_to'] ?? '/';
    }

    /**
     * Get the current logged in user, from the session or the remember me cookie
     * @return mixed The user ORM model or null if not logged in
     */
    public function getUser()
    {
        if (isset($_SESSION['user_id'])) {
            return $this->userRepository->getId($_SESSION['user_id']);
        } else {
            return $this->loginFromClientCookie();
        }
    }

    /**
     * Login the user from a remembered login cookie
     *
     * @return mixed [the user model if login cookie found: null otherwise]
     */
    private function loginFromClientCookie()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $token = TokenRepository::findByToken($cookie);

            if($token){

                $user = $this->userRepository->getId($token->user_id);

                $this->loginSession($user, false);

                return $user;

            }

        }
    }
}
