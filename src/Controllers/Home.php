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
       
       //1st Version 
        //method callled from Core/View
        //we used the namespace above at top of file that enabled us to call the render function 
        // View::render('Home/index.php', [
        //   'name' => 'Dave',
        //   'colours' => ['red', 'green', 'blue']
        // ]); 

        //2nd Version -Using the Twig Templating System - causing errors
        View::renderTemplate('Home/index.html', [
            'name' => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);

    }

 }
