<?php


class cvf
{

    const VERSION = '0.1.1';

    function __construct()
    {
        $this->debug_bar();
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

    public function is_cli()
	{
		return (PHP_SAPI === 'cli' OR defined('STDIN'));
	}

    public function is_php(string $version)
    {
        static $_is_php;
		$version = (string) $version;

		if ( ! isset($_is_php[$version]))
		{
			$_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
		}

		return $_is_php[$version];
    }

    public function is_https()
	{
		if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
		{
			return TRUE;
		}
		elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
		{
			return TRUE;
		}
		elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
		{
			return TRUE;
		}

		return FALSE;
	}

    public function debug_bar()
    {
        if(DEBUG !== TRUE) return;

    }

}
