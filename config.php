<?php

// defaults
define('MIN_PHP_VERSION', 7);

define('DEBUG', TRUE);

define('HTTPS', FALSE);

define('PORT', 88);
define('IP', '0.0.0.0');

define('DS', DIRECTORY_SEPARATOR);

define('APP_PATH', __DIR__ . DS);
define('APPPATH', __DIR__ . DS);

define('USER_APP_ROUTES_PATH', APP_PATH . 'routes' . DS);
define('USER_APP_ROUTES', 'web.php');

define('SRC_PATH', APP_PATH . 'src' . DS);

define('COMPOSER_AUTOLOAD', APP_PATH . 'vendor' . DS . 'autoload.php');

date_default_timezone_set('Asia/Calcutta');

chdir(APP_PATH);