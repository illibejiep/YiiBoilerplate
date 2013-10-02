<?php
define('LOCAL_DEBUG',true);
define('YII_DEBUG',true);
define('YII_TRACE_LEVEL',15);
error_reporting(-1);
ini_set('display_errors', true);

function dev_shutdown()
{
    $error = error_get_last();
    if ($error) {
        $uri = $_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
        $msg =  "fatal error:" . $uri . "\n"
            .'code: '.$error['type']."\n"
            .'message: '.$error['message']."\n"
            .'file: '.$error['file']."\n"
            .'line: '.$error['line']."\n\n";

        error_log($msg);
    }
}

register_shutdown_function('dev_shutdown');