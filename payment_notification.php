<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('payment_notification');
$log->pushHandler(new StreamHandler('php://stderr', Logger::WARNING));

$log->addWarning("LOG TEST");
$log->addWarning(json_encode($_POST));


http_response_code(200);