<?php

class cvf
{

    const VERSION = '0.0.2';

    function __construct()
    {
        
    }

    public function env(string $property)
    {
        $path = __DIR__.'\..\config.json';
        if(file_exists($path)) {
            $config = file_get_contents($path);
            if(!empty($config)){
                $config = json_decode($config);
                if(array_key_exists($property,$config)){
                    return $config->$property;
                } else {
                    throw new Exception('Config Property Not Found ', 1);
                }
            } else {
                    throw new Exception('Config File Empty ', 1);
                    
            }
        } else {
            throw new Exception('Config FIle Not Found', 1);
            
        }
    
    }

    public function lib(string $libName)
    {
        $path = __DIR__.'/../libs/'.$libName.'.php';
        if(file_exists($path)) {
            require_once $path;
        } else {
            throw new Exception('Libs Not Found', 1);
            
        }
    }

    
}
