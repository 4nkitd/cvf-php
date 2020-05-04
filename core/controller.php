<?php

class Controller extends cvf
{
    function __construct()
    {
        parent::__construct();
        
    }

    function redirect(string $path)
    {
        $goto = $this->env('appUrl');
        $goto .= $path;
        header('Location: '.$goto);
        exit;
    }
}
