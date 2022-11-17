<?php

namespace Core;

use App\Services\UserAuthentication;

/**
 * View
 * 
 */

 class View {

    /**
     * Render a view file 
     * 
     * @param string $view -  The view file 
     * 
     * @return void
     */

     public static function render($view, $args = []) {

        extract($args, EXTR_SKIP); 

        $file = "../App/Views/$view"; 

        if (is_readable($file)) {
            require $file;
        }else {
            throw new \Exception("$file not found");
        }

     }
    
    /**
     * Render a view template using Twig
     * 
     * @param string $template = The template file 
     * @param array $args  = Associative array of data to display in the view (optional)
     * 
     * @return void
     */

     public static function renderTemplate($template, $args =[]){

        static $twig = null;

        if($twig === null) {
            $userAuthentication = new UserAuthentication;
            $loader = new \Twig_Loader_Filesystem('../src/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('current_user', $userAuthentication->getUser());
            $twig->addGlobal('flash_messages', \App\Services\FlashMessageService::getMessages());

        }

        try {
            echo $twig->render($template,$args);
        } catch (\Throwable $th) {
            Error::exceptionHandler($th);
        }
       

     }






 }