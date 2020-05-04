<?php

class Bootstrap
{
    function __construct()
    {
        date_default_timezone_set('Asia/Calcutta');
        $this->routing();
        
    }

    public function routing()
    {
        require_once APPPATH.'app/routing.php';

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

        $file =  'app/' . $controller_name . '.php';

        if (file_exists($file)) {

            require_once $file;
            try {
                $controller = new $controller_name;

                if (isset($url[2])) {

                    $method = $url[1];

                    $controller->{$method}($url[2]);
                } else if (isset($url[1])) {
                    $method = $url[1];

                    $controller->{$method}();
                }
            } catch (\Throwable $th) {
                 new \Err($th,__FILE__);
            }
        } else {
             new \Err('Controller Not Found',__FILE__);
        }

    }
}
