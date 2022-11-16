<?php

require_once __DIR__ . '/files.php';
$app = new files();
require_once __DIR__ . '/router.php';
$router = new \Bramus\Router\Router();

function siteURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}

define( 'SITE_URL', siteURL() );