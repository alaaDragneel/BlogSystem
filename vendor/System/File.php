<?php

namespace System;

class File
{
    /**
    * Directory Separator
    *
    * @const $string
    */
    const DS = DIRECTORY_SEPARATOR;

    /**
    * [Roote Path]
    * @var [String]
    */
    private $root;

    /**
    * [__construct]
    * @param [string] $root [Root Path]
    */
    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
    * Determine Wether A file Path Exists
    *
    * @param [string] $file
    * @return boolean
    */
    public function exists($file)
    {
        return file_exists($this->to($file));
    }

    /**
    * Require The Given File
    *
    * @param [string] $file
    * @return mixed
    */
    public function call($file)
    {
        return require $this->to($file);
    }

    /**
    * Generate Full Path To The Given path
    *
    * @param [string] $path
    * @return string
    */
    public function to($path)
    {
        return $this->root . static::DS . str_replace(['/', '\\'], static::DS, $path);
    }
}
