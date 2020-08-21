<?php

require __DIR__ .  '/vendor/autoload.php';

if (!$_POST || !$_POST['product_title'] || !$_POST['product_price'] || !$_POST['product_quantity']) {
    header("Location: index.php");
}

/**
 * Sandbox token
 */
MercadoPago\SDK::setAccessToken('TEST-8948539626952155-061321-a29ce4bf0c00578dba394ef90d91c230-261498730');

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->title = $_POST['product_title'];
$item->quantity = $_POST['product_quantity'];
$item->unit_price = $_POST['product_price'];
$preference->items = [$item];
$preference->save();

header("Location: {$preference->sandbox_init_point}");