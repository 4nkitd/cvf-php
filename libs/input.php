<?php

/* 
    * @author     : 4nkitd@github
    * @authorName : Ankit
*/

class Input extends cvf
{
    public function __construct()
    {
        parent::__construct();
    }

    public function post(string $name, bool $filter = true , string $filter_type = FILTER_SANITIZE_STRING)
    {   
        if(!empty($_POST[$name])){
            if($filter){
                return filter_var($_POST[$name], $filter_type);
            } else {
                return $_POST[$name];
            }
        } else {
            return false;
        }
  
    }

    public function get(string $name, bool $filter = true , string $filter_type = FILTER_SANITIZE_STRING)
    {
        if(!empty($_GET[$name])){
            if($filter){
                return filter_var($_GET[$name], $filter_type);
            } else {
                return $_GET[$name];
            } 
        } else {
            return false;
        }
    }

    public function request(string $name, bool $filter = true , string $filter_type = FILTER_SANITIZE_STRING)
    {
        if(!empty($_REQUEST[$name])){
            if($filter){
                return filter_var($_REQUEST[$name], $filter_type);
            } else {
                return $_REQUEST[$name];
            }
         } else {
            return false;
        }
    }

     

}

