<?php

class Main extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        echo APPPATH.$this->env('appName');
    }

}
