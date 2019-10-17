<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Netflex\API;
use Dotenv\Dotenv;

Dotenv::create(__DIR__)->load();

API::setCredentials(
  getenv('NETFLEX_PUBLIC_KEY'),
  getenv('NETFLEX_PRIVATE_KEY'),
);

$test = 'hello_world';

dd($test, Netflex\Support\Str::toCamcelCase($test));
