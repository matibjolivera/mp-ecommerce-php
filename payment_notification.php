<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('payment_notification');
$log->pushHandler(new StreamHandler('php://stderr', Logger::WARNING));

$post = file_get_contents('php://input');
$log->warning("POST: " . $post);

http_response_code(200);