<?php

$yourStaticIP = '185.192.243.182';
if (\Config\Services::request()->getIPAddress() == $yourStaticIP) {

    error_reporting(-1);
    ini_set('display_errors', '1');

    defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

    defined('CI_DEBUG') || define('CI_DEBUG', true);
}
/*
|--------------------------------------------------------------------------
| ERROR DISPLAY
|--------------------------------------------------------------------------
| Don't show ANY in production environments. Instead, let the system catch
| it and display a generic error message.
*/
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);

/*
|--------------------------------------------------------------------------
| DEBUG MODE
|--------------------------------------------------------------------------
| Debug mode is an experimental flag that can allow changes throughout
| the system. It's not widely used currently, and may not survive
| release of the framework.
*/
defined('CI_DEBUG') || define('CI_DEBUG', false);
