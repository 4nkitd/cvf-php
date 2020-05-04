<?php

class session extends cvf
{
    public function __construct()
    {
        session_start();
        parent::__construct();

    }

    public function auth(bool $auth = false)
    {
        if($auth){ $_SESSION['logged_in']=$auth; } 
        
        else {
         
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
               
                define('SESSION_LOAD_TIME',time());
                
            } else {
                
                if($_GET['url']!='login' ){
                    header("Location: ".$this->env('appUrl').'login');
                }
            }

        }

        
    }

     

}
//! session class ended

function userdata(string $name,string $value=null)
    {   
        if($_SESSION){

            $flash = $_SESSION['userdata'];
            if(empty($value)){
                if(isset($flash[$name])){
                    $response = $flash[$name];
                } else {
                    $response = false;
                }
                return $response;
            } else {
                $_SESSION['userdata'][$name] = $value;
            }
                
        } else {
            return false;
        }
        
}

function flash(string $name,string $value=null,bool $vanish = true)
    { 
        if($_SESSION){
            if(isset($_SESSION['flash_data'])){
                $flash = $_SESSION['flash_data'];
            } else { 
                $_SESSION['flash_data'] = null;
                $flash = $_SESSION['flash_data'];

            }
                if(empty($value)){
                    $response = $flash[$name];
                    if($vanish){
                        $_SESSION['flash_data'][$name] = null; 
                    }
                    return $response;
                } else {
                    $_SESSION['flash_data'][$name] = $value;
                }
        } else {
            return false;
        }
       
    }