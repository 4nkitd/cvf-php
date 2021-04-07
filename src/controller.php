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

    public function json_response(array $response)      
    {
        header('Content-Type','application/json');
        $resp = json_encode($response,true);

        echo $resp ?? '';
    }
}
