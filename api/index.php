<?php

// File: api/index.php
// Entry point untuk Vercel PHP Runtime
// Meneruskan semua request ke Laravel public/index.php

$root = __DIR__ . '/../';
$uri  = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Sajikan file statis dari public/ jika ada
$staticFile = $root . 'public' . $uri;
if ($uri !== '/' && file_exists($staticFile) && !is_dir($staticFile)) {
    return false;
}

// Arahkan ke Laravel bootstrap
define('LARAVEL_START', microtime(true));

require_once $root . 'vendor/autoload.php';

$app = require_once $root . 'bootstrap/app.php';

$app->handleRequest(Illuminate\Http\Request::capture());
