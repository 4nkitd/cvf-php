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

    echo '
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