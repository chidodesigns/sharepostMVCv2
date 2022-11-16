<?php

namespace App\Controllers;

use Core\Controller;
use \Core\View;

use App\Models\Post;

/**
 * Posts controller
 * 
 */

 class Posts extends Authenticated  {
   
    /**
     * Show the index page
     * 
     * @return void 
     */
     public function indexAction() {

        View::renderTemplate('Posts/index.html');
     }

     /** 
      * Show the add new page
      * 
      * @return void 
     */
    public function createAction() {

        echo 'Hello from the addNew action in the Posts controller';

    }

    /**
     * Show the edit page
     * 
     * @return void 
     */

    public function editAction() {

        echo 'Hello from the edit action in the Posts controller!';
        echo '<p>Route parameters: <pre>' . htmlspecialchars(print_r($this->route_params,true)) . '</pre></p>';
    }


 }
