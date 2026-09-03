<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

$possiblePaths = [
    __DIR__.'/..',
    __DIR__.'/../absensi_bckend',
    __DIR__.'/../absensi_backend',
    __DIR__.'/../../absensi_bckend',
    __DIR__.'/../../absensi_backend',
    __DIR__.'/../..',
];

$basePath = __DIR__.'/..';
foreach ($possiblePaths as $path) {
    if (file_exists($path.'/bootstrap/app.php')) {
        $basePath = $path;
        break;
    }
}

if (!file_exists($basePath.'/.env')) {
    if (file_exists(__DIR__.'/.env')) {
        @copy(__DIR__.'/.env', $basePath.'/.env');
    } elseif (file_exists(__DIR__.'/../.env')) {
        @copy(__DIR__.'/../.env', $basePath.'/.env');
    }
}

if (!file_exists($basePath.'/.env')) {
    die("<div style='font-family:sans-serif; padding:30px; background:#fff3cd; color:#856404; border:1px solid #ffeba2; border-radius:8px; margin:50px auto; max-width:600px;'><h2>File .env Belum Ditemukan di Server Hostinger!</h2><p>File <b>.env</b> tidak ditemukan di folder: <code>".$basePath."/</code></p><p>Silakan buat file bernama <b>.env</b> di dalam folder tersebut melalui Hostinger File Manager dan isi kredensial database Hostinger kamu.</p></div>");
}

if (file_exists($configCache = $basePath.'/bootstrap/cache/config.php')) {
    @unlink($configCache);
}

$viewCacheDir = $basePath . '/storage/framework/views';
if (is_dir($viewCacheDir)) {
    foreach (glob($viewCacheDir . '/*.php') as $viewFile) {
        @unlink($viewFile);
    }
}

if (file_exists($maintenance = $basePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require $basePath.'/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once $basePath.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
