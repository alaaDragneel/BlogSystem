<?php

namespace System;

class Application
{
    /**
    * [Container]
    * @var [array]
    */
    private $container = [];

    /**
    * [__construct]
    * @param \System\File $file
    */
    public function __construct(File $file)
    {
        $this->share('file', $file);
        $this->registerClasses();
        $this->loadHelpers();
    }

    /**
    * Register Classes in  spl auto load register
    *
    * @return void
    */
    private function registerClasses()
    {
        spl_autoload_register([$this, 'load']);
    }

    /**
    * Load Classes to auto loading
    *
    * @param string $class
    * @return void
    */
    public function load($class)
    {
        if (strpos($class, 'App') === 0) {
            // get The Class From app
            $file = $this->file->toApp($class. '.php');

        } else {
            // get The Class From vendor
            $file = $this->file->toVendor($class. '.php');
        }

        if ($this->file->exists($file)) {
            $this->file->require($file);
        }
    }

    /**
    * Load Helpers File
    *
    * @return void
    */
    public function loadHelpers()
    {
        $this->file->require($this->file->toApp('App/Helpers/helpers.php'));
    }

    /**
    * Get Shared value
    *
    * @param string $Key
    * @return mixed
    */
    public function get($key)
    {
        return isset($this->container[$key]) ? $this->container[$key] : null;
    }

    /**
    * Share The Given Key|Value Through Application
    *
    * @param string $key
    * @param mixed $value
    * @return mixed
    */
    public function share($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
    * Get Shared value Dynamiclly
    *
    * @param string $Key
    * @return mixed
    */

    public function __get($key)
    {
        return $this->get($key);
    }

}
