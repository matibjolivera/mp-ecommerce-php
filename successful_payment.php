<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('successful_payment.php');
$log->pushHandler(new StreamHandler('php://stderr', Logger::INFO));

$log->info("GET: " . json_encode($_GET));

echo json_encode($_GET);