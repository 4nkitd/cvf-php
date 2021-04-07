<?php

class Err extends cvf
{
    function __construct($info,$Location)
    {
        $this->view = new View;
		$this->view->render('error',['err'=>$info,'file'=>$Location]);
		die;
    }

    public function error($severity, $message, $filepath, $line)
	{
		
		if ( ! $this->is_cli())
		{
			$filepath = str_replace('\\', '/', $filepath);
			if (FALSE !== strpos($filepath, '/'))
			{
				$x = explode('/', $filepath);
				$filepath = $x[count($x)-2].'/'.end($x);
			}

			$template = 'html'.DIRECTORY_SEPARATOR.'error_php';
		}
		else
		{
			$template = 'cli'.DIRECTORY_SEPARATOR.'error_php';
		}

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include($templates_path.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
	}
}
