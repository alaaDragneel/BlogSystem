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
    }

    /**
    * Register  Classes in  spl auto load register
    *
    * @return void
    */
   private function registerClasses()
   {
       spl_autoload_register();
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
}
