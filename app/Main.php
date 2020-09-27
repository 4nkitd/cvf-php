<?php

class Main extends Controller
{
    public $twitch;

    function __construct()
    {
        parent::__construct();
        $this->view = new View();

    }

    function index()
    {
        $this->view->load('main');
    }

    

}
