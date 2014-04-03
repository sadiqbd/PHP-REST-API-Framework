<?php

if (getenv('APPLICATION_ENV') != "staging")
{
    set_error_handler('handleError', E_ALL);
}

require_once 'config.php';

function __autoload($class) {
    $parts = explode('\\', $class);
    $parts = array_map("ucfirst", $parts);
    //echo implode("/", $parts) . '.php<br \>';
    require implode("/", $parts) . '.php';
}

function handleError($errno, $errstr, $errfile, $errline) {
    switch ($errno) {
        case 1: $e_type = 'E_ERROR';
            $exit_now = true;
            break;
        case 2: $e_type = 'E_WARNING';
            break;
        case 4: $e_type = 'E_PARSE';
            break;
        case 8: $e_type = 'E_NOTICE';
            break;
        case 16: $e_type = 'E_CORE_ERROR';
            $exit_now = true;
            break;
        case 32: $e_type = 'E_CORE_WARNING';
            break;
        case 64: $e_type = 'E_COMPILE_ERROR';
            $exit_now = true;
            break;
        case 128: $e_type = 'E_COMPILE_WARNING';
            break;
        case 256: $e_type = 'E_USER_ERROR';
            $exit_now = true;
            break;
        case 512: $e_type = 'E_USER_WARNING';
            break;
        case 1024: $e_type = 'E_USER_NOTICE';
            break;
        case 2048: $e_type = 'E_STRICT';
            break;
        case 4096: $e_type = 'E_RECOVERABLE_ERROR';
            $exit_now = true;
            break;
        case 8192: $e_type = 'E_DEPRECATED';
            break;
        case 16384: $e_type = 'E_USER_DEPRECATED';
            break;
        case 30719: $e_type = 'E_ALL';
            $exit_now = true;
            break;
        default: $e_type = 'E_UNKNOWN';
            break;
    }

    if (getenv('APPLICATION_ENV') == "development") {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }else {
        error_log(date("F j, Y, g:i a\n").$e_type.": ".$errstr." in ".$errfile." on line ".$errline."\n\n", 3, getConfig('error_file'));
        
        if(getConfig('enable_error_email'))
        {
            ob_start();
            echo $errstr." in ".$errfile." on line ".$errline."\n\n\n";
            debug_print_backtrace();
            $message = ob_get_contents();
            mail(getConfig('error_notify_email'), $e_type.": ".date("F j, Y, g:i a\n"), $message);
            ob_end_clean();
        }
            
    }
}

function getConfig($key) {
    global $config;
    return $config[$key];
}

