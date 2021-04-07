<?php



function is_https(){
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) {

        return true;

    } else {

        return false;

    }
}

function encrypt_email_js($email)
{
    $pieces = explode("@", $email);

    return `
			<script type="text/javascript">
				var a = "<a href=\'mailto:";
				var b = "' . $pieces[0] . '";
				var c = "' . $pieces[1] . '";
				var d = "\' class=\'email\'>";
				var e = "</a>";
				document.write(a+b+"@"+c+d+b+"@"+c+e);
			</script>
			<noscript>Please enable JavaScript to view emails</noscript>
		`;
}
