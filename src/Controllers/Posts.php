<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Post;

/**
 * Posts controller
 * 
 */

 class Posts extends \Core\Controller  {

    /**
     * Show the index page
     * 
     * @return void 
     */
     public function indexAction() {

        $this->requireLogin();
        View::renderTemplate('Posts/index.html');
     }

     /** 
      * Show the add new page
      * 
      * @return void 
     */
    public function addNewAction() {

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
