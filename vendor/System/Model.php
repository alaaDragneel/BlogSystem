<?php

namespace System;

abstract class Model
{
    /**
    * Application object
    *
    * @var \System\Application
    */
    protected $app;

    /**
     * Table name
     *
     * @var sttring
     */
    protected $table;

    /**
    * Constructor
    * @param \System\Application $app
    */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Call shared Application Objects Dynamiclly
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->app->get($key);
    }

    /**
     * Call Database Methods Dynamiclly
     *
     * @param string $method
     * @param array $arrguments
     * @return mixed
     */
    public function __call($method, $arrguments)
    {
        return call_user_func_array([$this->app->db, $method], $arrguments);
    }

    /**
    * Get All data
    *
    * @return array
    */
    public function all()
    {
        return $this->get($this->table);
    }

    /**
    * Get data By Id
    *
    * @param int $id
    * @return \stdClass|null
    */
    public function find($id)
    {
        return $this->where('id = ?', $id)->first($this->table);
    }

}
