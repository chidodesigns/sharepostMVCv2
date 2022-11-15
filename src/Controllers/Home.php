<?php

namespace App\Controllers;

use App\Repository\UserRepository;
use App\Services\UserAuthentication;
use Core\Controller;
use Core\View;


/**
 * Home controller
 *  
 */

 class Home extends Controller {

     /**
      * Before Filter
      *
      *@return void
      */

      protected function before() {

        //this return false statement stops the script from executing after this function has been called - useful for authentication
        // return false;
        

      }

      /**
       * After Filter
       * 
       * @return void
       */
      protected function after() {

   

      }

    /**
     * Show the index page
     * 
     * @return void 
     */

     public function indexAction() {

        View::renderTemplate('Home/index.html');

    }

 }
