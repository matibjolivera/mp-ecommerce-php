<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('payment_notification');
$log->pushHandler(new StreamHandler('php://stderr', Logger::WARNING));

$log->warning("LOG TEST");
$log->warning(json_encode($_POST));
$log->warning(json_encode($_GET));
$log->warning(json_encode($_REQUEST));
$log->warning(json_encode($_POST["id"]));

http_response_code(200);