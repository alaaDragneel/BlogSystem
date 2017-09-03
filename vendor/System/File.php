<?php

namespace System;

class File
{
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
}
