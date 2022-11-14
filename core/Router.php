<?php

namespace Core;

class Router {

    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array 
     */
    protected $params = [];

    /**
     * Add a route to the routing table 
     * 
     * @param string $route the route URL
     * @param array $params Parameters (controller, action, etc.)
     */

     public function add( $route, $params = [] ){
         
    //Regular experssion replacing in PHP 
    //$result = preg_replace($reg_exp, $replacement, $string)
    //Searches $string for matches to $reg_exp and replaces them with $replacement

    //Turning the route into a regular expression
    //route -> {controller}/{action}

    //escape special character forwardslashes / as these are special characters with regular expressions
    //replace forward slash with a backslash and forwardslash (meaning the $route that has been passed in has its forward slashes escaped)
    $route = preg_replace('/\//', '\\/', $route);

    //updated route -> {controller}\/{action}

    //Processing the route containing variables  - To match the route to the request URL, it needs to be converted to a regular expression:
  
    //Convert variables e.g. {controller}
    //square brackets (character sets) [] - Match any of the charaters in the brackets, e.g -> [abc] will match a, b or c and nothing else
    //brackets () are reg exp 'capture groups' -> capture the regular expression inside the parentheses (the subpattern) to a capture group
    //[^ ] = negate the character class: match any one character EXCEPT for the characters specified, including ranges:
    //curly braces denote a variable part within the route - it is being replaced with a named capture group

    $route = preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)', $route);

    //updated route -> (?P<controller>[a-z]+)\/(?P<action>[a-z-]+)

    //Convert variables with custom regular expressions e.g. {id:\d+}
    //if we dont have a regular exp (within the URL) then it will default to the normal URL controller/action route
    //The ^ caret has multiple meanings -> in this case - As its at the start of a Reg Exp - it means the start of the string, but if its the first character inside a character group (square brackets) it negates the group.
    //<\1> is displaying the capture group name 'controller' , 'id', 'action' -> is /2capturing the custom regular expression \d+? (ANS) -> The first capture group is what's inside the first brackets, which is whatever matched [a-z]+ after the opening curly bracket was matched. This is 'controller', 'action', or 'id' or whatever the variable is called as you say. This string is what \1 refers to in the second regular exp -> -> ->
    //The second capture group is what's inside the second brackets, which is whatever matched [^\}]+. This is anything after the colon that isn't a closing curly brace. So yes, this captures the custom regular exp.
    $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

    //Add start and end delimiters, and case insensitive flag
    $route = '/^' . $route . '$/i';

    $this->routes[$route] = $params;

     }

     /**
      * Get all the routes from the routing table 
      *
      *@return array
      */
     
      public function getRoutes() {
          return $this->routes;
      }

      /**
       * Match the route to the routes in the routing table, setting the $pasrams property if a route is found.
       * 
       * @param string $url The route URL
       * 
       * return boolean     true if a match found, false otherwise
       */
      public function match($url) {

          foreach ($this->routes as $route => $params) {

        //reg exp match on each route
          if(preg_match($route, $url, $matches)) {
            //Get named capture group values
            // $params = [];

            foreach($matches as $key => $match){
                if(is_string($key)) {
                    $params[$key] = $match;
                }
            }
            $this->params = $params;
            return true;
            }

          }


        return false;

      }

      public function dispatch($url) {

        $url = $this->removeQueryStringVariables($url);

        //if we have a match within the routing table 
        if ($this->match($url)) {

            //assign controller var to the params array controller key/value pair
            $controller = $this->params['controller'];

            //convert to studly caps - as this will eventually correspond to a controller class name
            $controller = $this->convertToStudlyCaps($controller);

            //this namespace convention will help us identify the class name *commented out*
            // $controller = "App\Controllers\\$controller";
            
            //call the getNamespace func -> to get the namespace and get the namespace param if one is supplied
            $controller = $this->getNamespace() . $controller;

            //now that $controller has been converted to studly we check if the new controller name is a class
            if (class_exists($controller)) {

                //if class exists then we instantiate the object - and pass in route params coming from the router
                $controller_object = new $controller($this->params);
                //we repeat this process for the action parameter from the URL
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                //This code uses the preg_match function to check that the name of the action doesnt end in "Action" (or "action" - the "i" flag means its case insensitive) - if it does'nt,then the method is called. if it does, then an exeception is raised. 
                if (preg_match('/action$/i', $action) == 0) {
                    //we call the action method associated with the class object instance
                    $controller_object->$action();

                }else{

                    throw new \Exception("Method $action (in controller $controller) not found");
                    
                }
            }else {

                // echo "Controller class $controller not found";
                throw new \Exception("Controller class $controller not found");

            }

        }else {
            // echo 'No route matched';
            throw new \Exception('No route matched.', 404);
        } 

      }

      /**
       * Convert the string with hyphens to StudlyCaps.
       * e.g. post-authors => PostAuthors
       * 
       * @param string $string The string to convert
       * 
       * @return string
       */
        protected function convertToStudlyCaps($string) {
            //ucwords caps first letter of each word
            return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        }

        /**
         * Convert the string with hyphens to camelCase,
         * e.g. add-new => addNew
         * 
         * @param string $string The string to convert
         * 
         * @return string 
         */
         protected function convertToCamelCase($string) {

            return lcfirst($this->convertToStudlyCaps($string));

         }

      /**
       * Remove the query string variables from the URL (if any). As the full query string is used for the route, any variables at the end will need to be removed before the route is matched to the routing table. For example:
       * URL                        $_SERVER['QUERY_STRING]         Route
       * -----------------------------------------------------------------
       * localhost                          ''                         ''
       * localhost/?                        ''                         ''
       * localhost/?page=1                  page=1                     ''
       * localhost/posts?page=1             posts&page=1               posts
       * localhost/posts/index              posts/index                posts/index
       * localhost/posts/index?page=1       posts/index&page=1         posts/index
       * 
       * A URL of the format localhost/?page (one variabnle name, no value) won't work however. (NB. The .htaccess file converts the first ? to a & when it's passed through to the $_SERVER variable).
       * 
       * @param string $url The full URL 
       * 
       * @return string The URL with the query string variables removed
       * 
       */

         protected function removeQueryStringVariables($url) {

            if ($url != '') {
                
                $parts = explode('&', $url, 2);

                if(strpos($parts[0], '=')  === false){
                    $url = $parts[0];
                }else{
                    $url = '';
                }
            }
            return $url;
         }

        /**
         * Get the namespace for the controller class. The namespace defined in the route parameters is added if present.
         * 
         * @return string The request URL
         */
         protected function getNamespace() {

            //namespace defaults to app controllers
            $namespace = 'App\Controllers\\';

            if (array_key_exists('namespace', $this->params)) {
                //add to already defined namespace above 
                $namespace .= $this->params['namespace'] . '\\';
            }

            return $namespace;

         }


        /**
         * Get the currently matched parameters
         * 
         * @return array
         */
        public function getParams() {
            return $this->params;
        }
}
   