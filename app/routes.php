<?php

$route['default'] = 'Main/index';

$route['login'] = 'Auth/login';
$route['signup'] = 'Auth/signup';
$route['register'] = 'Auth/register';
$route['process'] = 'Auth/login_post';
$route['v'] = 'Auth/verify_email';
$route['rev'] = 'Auth/resend_v_email';
