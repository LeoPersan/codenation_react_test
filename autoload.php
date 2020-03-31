<?php

define('DS', DIRECTORY_SEPARATOR);

function autoload($classname)
{
    $paths = explode('\\',$classname);
    $filename = array_pop($paths).'.php';
    $full_path = getcwd().DS.implode(DS, $paths).DS.$filename;
    if (is_file($full_path))
        include_once($full_path);
}

spl_autoload_register('autoload');