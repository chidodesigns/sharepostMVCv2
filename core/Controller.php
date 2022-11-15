<?php

namespace Core;

use App\Services\UserAuthentication;

/**
 * Base controller
 * 
 */

abstract class Controller
{

  /**
   * Parameters from the matched route
   * @var array
   */

  protected $route_params = [];

  /**
   * Class constructor
   *
   *@param array $route_params Parameters from the route
   *
   *@return void
   */

  public function __construct($route_params)
  {

    $this->route_params = $route_params;
  }

  /**
   * Method to be called on Controller Action
   *
   * @param [type] $name
   * @param [type] $args
   * @return void
   */
  public function __call($name, $args)
  {

    $method = $name . 'Action';

    if (method_exists($this, $method)) {

      if ($this->before() !== false) {

        call_user_func_array([$this, $method], $args);
        $this->after();
      } else {

        throw new \Exception("Method $method not found in controller " . get_class($this));
      }
    }
  }

  /**
   * Redirect to a different page
   *
   * @param [type] $url
   * @return void
   */
  protected function redirect($url)
  {

    header('Location: http://' .  $_SERVER['HTTP_HOST'] . $url , true, 303);
    exit;
  }

  /**
   * Before filter - call before an action method.
   * 
   * @return void
   */
  protected function before()
  {
  }

  /**
   * After filter - called after an action method.
   * 
   * @return void
   */
  protected function after()
  {
  }

  /**
   * Require the user to be logged in before giving access to the requested page.
   * Remeber the requested page for later, then redirect to the login page
   *
   * @return void
   */
  public function requireLogin()
  {
    if(!UserAuthentication::isLoggedIn())
    {
        UserAuthentication::rememberRequestedPage();
        $this->redirect('/login');
    }
  }
}
