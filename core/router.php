<?php 

class Router extends Bootstrap
{

    function __construct()
    {
        $this->https_redirect();
        $this->routing();
    }

    function https_redirect()
    {
        if($this->env('https')==FALSE) return;

        if($this->is_https()===TRUE) return;

        $location = 'https://' . $this->env('appUrl');
        // header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);

        exit;
    }

    function routing(){

        if(empty(ROUTES)) return;

        require_once ROUTES;
        
        if(empty($_GET['url'])){
            $url = $route['default'];
        } else {
            $path = $_GET['url'];
            if(isset($route[$path])){
                $url = $route[$path];
            } else {
                $url = $path;
            }
        }

        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $controller_name = $url[0];

        $file =  'app'. DS . $controller_name . '.php';

        if (!file_exists($file)){
            new Err('Controller Not Found',__FILE__);
        }  

            require_once $file;
            
            $controller = new $controller_name;

            if (isset($url[2])) {

                $method = $url[1];

                $controller->{$method}($url[2]);
            } else if (isset($url[1])) {
                $method = $url[1];

                $controller->{$method}();
            }
        
    }
}
