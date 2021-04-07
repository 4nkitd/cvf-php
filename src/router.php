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
        if(HTTPS===FALSE) return;

        if($this->is_https()===TRUE) return;

        $location = 'https://' . $this->env('appUrl');
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit;
    }

    function routing(){


        if (is_array(USER_APP_ROUTES)) {

            foreach (USER_APP_ROUTES as $that_route) {

                require(USER_APP_ROUTES_PATH . $that_route);
            }

        } else {

            require USER_APP_ROUTES_PATH . USER_APP_ROUTES;

        }
        
        if(empty($_GET['url'])){

            $url = $route['default'][1];

        } else {

            $path = $_GET['url'];

            if(isset($route[$path][1])){

                $url = $route[$path][1];

                if ($_SERVER['REQUEST_METHOD'] !== $route[$path][0]) {
                    die("This user doesn't support {$_SERVER['REQUEST_METHOD']} method.");
                }


            } else {

                $url = $path;
                
            }

        }

        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $controller_name = $url[0];

        $file =  APP_PATH .'app'.DS. $controller_name . '.php';

        if (!file_exists($file)){
            new Err('Controller Not Found',__FILE__.':'.__LINE__);
        }  

        try {

            require_once $file;

            $controller = new $controller_name;

            if (isset($url[2])) {

                $method = $url[1];

                $controller->{$method}($url[2]);
            } else if (isset($url[1])) {
                $method = $url[1];

                $controller->{$method}();
            }

        } catch (\Throwable $th) {
            
            new Err($th->getMessage(), $th->getFile() . ':' . $th->getLine());
            
        } catch (\Exception $e) {

            new Err($e->getMessage(), $e->getFile() . ':' . $e->getLine());
        }
            
        
    }
}
