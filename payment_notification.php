<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('payment_notification');
$log->pushHandler(new StreamHandler('php://stderr', Logger::WARNING));

var_dump($_POST);die();

http_response_code(200);