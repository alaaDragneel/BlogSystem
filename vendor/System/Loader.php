<?php

namespace System;

class Loader
{
    /**
    * Application object
    *
    * @var \System\Application
    */
    private $app;

    /**
    * Controllers Container
    *
    * @var array
    */
    private $controllers = [];

    /**
    * Models Container
    *
    * @var array
    */
    private $models = [];

    /**
    * Constructor
    * @param \System\Application $app
    */

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Call The Given Controller With The GIven method
     * and pass the given aguments to the Container method
     *
     * @param string $controller
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function action($controller, $method, $arguments)
    {
        $object = $this->controller($controller);
        return call_user_func_array([$object, $method], $arguments);
    }

    /**
     * Call The Given Controller
     *
     * @param string $controller
     * @return object
     */
    public function controller($controller)
    {
        $controller = $this->getControllerName($controller);
        if (! $this->hasController($controller)) {
            $this->addController($controller);
        }

        return $this->getController($controller);
    }

    /**
     * Determine if the given class|controller exists
     * in the Controllers container
     *
     * @param string $controller
     * @return boolean
     */
    private function hasController($controller)
    {
        return array_key_exists($controller, $this->controllers);
    }

    /**
     * Create new Object From The Given controller and stor it
     * in the Controllers container
     *
     * @param string $controller
     * @return void
     */
    private function addController($controller)
    {
        $object = new $controller($this->app);

        $this->controllers[$controller] = $object;
    }

    /**
     * Get The Controller Object
     *
     * @param string $controller
     * @return object
     */
    private function getController($controller)
    {
        return $this->controllers[$controller];
    }

    /**
     * Get The Full Class|Controller
     *
     * @param string $controller
     * @return string
     */
    private function getControllerName($controller)
    {
        $controller = 'App\\Controllers\\' . $controller;
        return str_replace('/', '\\', $controller);
    }

    /**
     * Call The Given Model
     *
     * @param string $model
     * @return object
     */
    public function model($model)
    {
        //
    }

    /**
     * Determine if the given class|model exists
     * in the Modles container
     *
     * @param string $model
     * @return boolean
     */
    private function hasModel($model)
    {
        //
    }

    /**
     * Create new Object From The Given Modle and stor it
     * in the Modles container
     *
     * @param string Modle
     * @return void
     */
    private function addModel($model)
    {
        //
    }

    /**
     * Get The Modle Object
     *
     * @param string $model
     * @return object
     */
    private function getModel($model)
    {
        //
    }
}
