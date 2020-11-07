<?php

/* 
    * @author     : 4nkitd@github
    * @authorName : Ankit
*/

class Avtar extends cvf
{

    function email_gravatar($email,$size=32,$default = ''){

        return 'http://www.gravatar.com/avatar/' . md5(strtolower( trim($email))) 
        . '?s='.$size
        . '?d='.urlencode($default);
    
    }

}