<?php

namespace Core;

/**
 * Base controller
 * 
 */

//Will not be instantiating object instances of this class - however we will instantiate objects that extend this class
 abstract class Controller {

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

      public function __construct($route_params) {

        $this->route_params = $route_params;

      }
      //We are creating the ability to invoke actions BEFORE & AFTER the ACTION METHOD is called
      //__call() is triggered when invoking inaccessible methods in an object context.
      //$name stands for the method that is being called from the object -> $args stands for the arguements that is meant to be associated with that method call
      public function __call($name, $args) {

        //adding the action suffix to the method name 
        $method = $name . 'Action';

        if (method_exists($this, $method)) {

            if($this->before() !== false) {
              
                //call_user_func_array — Call a callback with an array of parameters
                call_user_func_array([$this, $method], $args);
                $this->after();

            } else{

                throw new \Exception("Method $method not found in controller " . get_class($this));

            }
        }

      }

      /**
       * Before filter - call before an action method.
       * 
       * @return void
       */
      protected function before() {


      }

      /**
       * After filter - called after an action method.
       * 
       * @return void
       */
      protected function after() {
          
      }

 }