<?php

namespace Core;

use Exception;

class Router
{

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

    public function add($route, $params = [])
    {

        $route = preg_replace('/\//', '\\/', $route);

        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

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

    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match the route to the routes in the routing table, setting the $pasrams property if a route is found.
     * 
     * @param string $url The route URL
     * 
     * return boolean     true if a match found, false otherwise
     */
    public function match($url)
    {

        foreach ($this->routes as $route => $params) {

            if (preg_match($route, $url, $matches)) {

                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }


        return false;
    }

    public function dispatch($url)
    {

        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {

            $controller = $this->params['controller'];

            $controller = $this->convertToStudlyCaps($controller);

            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {

                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {

                    throw new Exception("Method $action (in controller $controller) not found");
                }
            } else {

                // echo "Controller class $controller not found";
                throw new Exception("Controller class $controller not found");
            }
        } else {
            // echo 'No route matched';
            throw new Exception('No route matched.', 404);
        }
    }

    /**
     * Convert the string with hyphens to StudlyCaps.
     * 
     * @param string $string The string to convert
     * 
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
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
    protected function convertToCamelCase($string)
    {

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

    protected function removeQueryStringVariables($url)
    {

        if ($url != '') {

            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=')  === false) {
                $url = $parts[0];
            } else {
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
    protected function getNamespace()
    {

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
    public function getParams()
    {
        return $this->params;
    }
}
