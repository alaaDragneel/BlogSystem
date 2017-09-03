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
        return file_exists($file);
    }

    /**
    * Require The Given File
    *
    * @param [string] $file
    * @return void
    */
    public function require($file)
    {
        require $file;
    }

    /**
    * Generate Full Path To The Given path in App Folder
    *
    * @param [string] $path
    * @return string
    */
    public function toApp($path)
    {
        return $this->to($path);
    }

    /**
    * Generate Full Path To The Given path in Vendor Folder
    *
    * @param [string] $path
    * @return string
    */
    public function toVendor($path)
    {
        return $this->to('vendor' . static::DS . $path);
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
