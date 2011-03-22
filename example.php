<?php

/**
 * This example simply reads and outputs the contents of stdin.
 */

spl_autoload_register(function($className) {
    $className = str_replace("\\",'/', $className);
    include $className . '.php';
});

set_include_path('.:lib/');

use EventPHP\Streams\ReadableStream as Stream;
use EventPHP\Events\Loop as Loop;

$stream = new Stream(STDIN);
$stream->on('data', function($data) {
    echo $data;
});
$stream->on('end', function() {
    echo "EOF reached\n";
});

Loop::getInstance()->loop();

?>
