<?php

namespace System\View;

use System\File;

class View implements ViewInterface
{
    /**
    * File object
    *
    * @var \System\File
    */
    private $file;

    /**
    * View Path
    *
    * @var string
    */
    private $viewPath;

    /**
    * Passed data "[ Variables ]" To The View Path
    *
    * @var array
    */
    private $data = [];

    /**
    * the Output From the View File
    *
    * @var string
    */
    private $output;

    /**
    * Constructor
    * @param \System\File $file
    */
    public function __construct(File $file, $viewPath , array $data)
    {
        $this->file = $file;
        $this->preparePath($viewPath);
        $this->data = $data;
    }

    /**
    * Prepare View Path
    *
    * @param string $viewPath
    * @return void
    */
    private function preparePath($viewPath)
    {
        $relativeViewPath = 'resources/views/' . $viewPath . '.php';
        $this->viewPath = $this->file->to($relativeViewPath);
        if (! $this->viewFileExists($relativeViewPath)) {
            die('<b>' . $viewPath . ' View </b>'. ' Doesn\'t Exists In Views Folder');
        }
    }

    /**
    * Determin if View
    *
    * @return boolean
    */
    private function viewFileExists($viewPath) {

        return $this->file->exists($viewPath);
    }

    /**
    * @inheritDoc
    */
    public function getOutput()
    {
        if (is_null($this->output)) {
            // stop the output to render in the browser
            ob_start();

            extract($this->data);

            require $this->viewPath; // require the view

            $this->output = ob_get_clean(); // get the view and store it
        }
        return $this->output;
    }

    /**
    * @inheritDoc
    */
    public function __toString()
    {
        return $this->getOutput();
    }
}
