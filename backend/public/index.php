<?php

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__).'/vendor/autoload.php';
require_once dirname(__DIR__).'/config/bootstrap.php';

$kernel = new Kernel(
    $_SERVER['APP_ENV'] ?? 'dev',
    filter_var($_SERVER['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN)
);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
