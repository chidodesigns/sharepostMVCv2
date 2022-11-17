<?php

namespace App\Controllers;

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

      $data = [
        'title' => 'SharePosts',
        'description' => 'Simple Shareposts App Built On Top Of A Custom PHP MVC Framework'
      ];

        View::renderTemplate('Home/index.html', [
          'data' => $data
        ]);

    }

 }
