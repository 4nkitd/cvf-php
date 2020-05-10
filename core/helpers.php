<?php

function dd($obj){

    if(is_string($obj)){
        echo $obj;
    } else {
        echo '<pre>';
        print_r((array)$obj);
    }

    die();

}

function gravatar_image_gern($email,int $size = 32)
{
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) return false;

    $gravatar_link = 'http://www.gravatar.com/avatar/' . md5($comment_author_email) . '?s='.$size;
    
    return '<img src="' . $gravatar_link . '" />';
}

function resize_image($file, $w, $h, $crop = false)
{
    $file = file_get_contents($file);

    $src = imagecreatefromstring($file);
    if (!$src) {
        return false;
    }

    $width = imagesx($src);
    $height = imagesy($src);

    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
    }
    //$src = imagecreatefrompng($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    // Buffering
    ob_start();
    imagepng($dst);
    $data = ob_get_contents();
    ob_end_clean();
    // return $data;
    return 'data:image/jpeg;base64,' . base64_encode($data);
}

function js_write_email($email)
{
    $pieces = explode("@", $email);

    return '
			<script type="text/javascript">
				var a = "<a href=\'mailto:";
				var b = "' . $pieces[0] . '";
				var c = "' . $pieces[1] . '";
				var d = "\' class=\'email\'>";
				var e = "</a>";
				document.write(a+b+"@"+c+d+b+"@"+c+e);
			</script>
			<noscript>Please enable JavaScript to view emdails</noscript>
		';
}

function response(array $response = [],int $code = 200,string $type = 'json'){

    $statusCodes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',  // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    ];

    $status = $statusCodes[$code];

    header("HTTP/1.1 ".$code." ".$status);

    if($type == 'json'){
        header('Content-Type: application/json');
        $response = json_encode($response,true);
    } elseif ($type == 'xml') {
        header('Content-type: application/xml');
        $response = simplexml_load_string($response);
    }

    $length = strlen($response);

    header('Content-Length: '.$length);

    echo $response;

    exit();
}