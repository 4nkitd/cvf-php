<?php

class Err
{
    function __construct($info,$Location)
    {
        $this->view = new View;
        $this->view->render('error',['err'=>$info]);
    }
}
