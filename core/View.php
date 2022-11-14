<?php

namespace Core;

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

        //The extract() function imports variables into the local symbol table from an array.
        //This function uses array keys as variable names and values as variable values. For each element it will create a variable in the current symbol table.
        //This function returns the number of variables extracted on success.
        //EXTR_SKIP
        //If there is a collision, don't overwrite the existing variable.
        extract($args, EXTR_SKIP); 

        $file = "../App/Views/$view"; // relativ to Core directory

        if (is_readable($file)) {
            require $file;
        }else {
            // echo "$file not found";
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

            $loader = new \Twig_Loader_Filesystem('../src/Views');
            $twig = new \Twig_Environment($loader);

        }

        echo $twig->render($template,$args);

     }






 }