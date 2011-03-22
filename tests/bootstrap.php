<?php

date_default_timezone_set('UTC');


spl_autoload_register(function($className) {
    $className = str_replace("\\",'/', $className);
    include $className . '.php';
});

set_include_path(
    get_include_path() . 
    PATH_SEPARATOR . '.' .
    PATH_SEPARATOR . __DIR__ . '/../lib/'
);

?>
