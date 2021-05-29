<?php

function classAutoLoader($class){
    $class=strtolower($class);
    $the_path="includes/{$class}.php";

    if(file_exists($the_paths)){
        require_once($the_path);
    }else{
        die("This file name {$class}.php not available");
    }
}

spl_autoload_register('classAutoLoader');

function redirect($location)
{
    header("Location: {$location}"); 
}