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
    * Run The Application
    *
    * @return void
    */
    public function run()
    {
        $this->session->start();

        $this->request->prepareUrl();
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
        if (! $this->isSharing($key)) {
            if ($this->isCoreAlias($key)) {
                $this->share($key, $this->createNewCoreObject($key));
            } else {
                die('<b>'. $key .'</b> Not Found In Application Container');
            }
        }

        return $this->container[$key];
    }

    /**
    * Detremaine If The Given Key Is Shared To Apllication
    *
    * @param string $Key
    * @return boolean
    */
    public function isSharing($key)
    {
        return isset($this->container[$key]);
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
    * Determine If The Given Key Is An Aliase To Core Class
    *
    * @param string $alias
    * @return boolean
    */
    private function isCoreAlias($alias)
    {
        $coreClasses = $this->coreClasses();

        return isset($coreClasses[$alias]);
    }

    /**
    * Create new Object for the core class based on the given alias
    *
    * @param string $alias
    * @return boolean
    */
    private function createNewCoreObject($alias)
    {
        $coreClasses = $this->coreClasses();

        $object = $coreClasses[$alias];

        return new $object($this);
    }

    /**
    * Get All Core Classes With Its Aliases
    *
    * @return array
    */
    private function coreClasses()
    {
        return [
            'request'           => 'System\\Http\\Request',
            'response'          => 'System\\Http\\Response',
            'session'           => 'System\\Session',
            'cookie'            => 'System\\Cookie',
            'load'              => 'System\\Load',
            'Html'              => 'System\\Html',
            'db'                => 'System\\Database',
            'view'              => 'System\\View\\ViewFactory',
        ];
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
