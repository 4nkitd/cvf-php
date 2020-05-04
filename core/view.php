<?php

class View extends Controller
{
    function __construct($db ='')
    {
        parent::__construct();
        
        if(!empty($db)){

            $this->db = $db;

        }
    }

    public function render($view_name, $view_data = [])
    {
        $this->data = $view_data;
        
        require_once 'views/' . $view_name . '.php';
    }

    public function load(string $view_name)
    {
        require_once 'views/' . $view_name . '.php';
    }
}
