<?php

function dd($that){

    if(is_string($that)){
        echo $that;
    } else {
        echo '<pre>';
        print_r((array)$that);
    }

    die();

}