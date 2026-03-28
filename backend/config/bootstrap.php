<?php

use Symfony\Component\Dotenv\Dotenv;

if (!class_exists(Dotenv::class)) {
    throw new \LogicException('Please run "composer install".');
}

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

$_SERVER += $_ENV;
