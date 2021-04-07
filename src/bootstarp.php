<?php

$imp_files = [
    'cvf.php',
    'err.php',
    'helpers.php',
    'controller.php',
    'view.php',
];

foreach ($imp_files as $that_file) {

    require_once(SRC_PATH . $that_file);

}

unset($imp_files);

if(is_array(USER_APP_ROUTES)){

    foreach (USER_APP_ROUTES as $that_route) {

        require_once(USER_APP_ROUTES_PATH . $that_route);
    }

} else {

    require_once(USER_APP_ROUTES_PATH . USER_APP_ROUTES);

}

if (file_exists(COMPOSER_AUTOLOAD)) {
    require_once(COMPOSER_AUTOLOAD);
} 

class Bootstrap extends cvf
{
    protected  $router;

    function __construct()
    {
        $this->_init_handler();
    }

    function _init_handler()
    {
        require_once(SRC_PATH . 'router.php');
        
        $this->router = new Router();
        
    }
}
