<?php

require __DIR__ . '/vendor/autoload.php';

if (!$_POST || !$_POST['product_title'] || !$_POST['product_price'] || !$_POST['product_image']) {
    header("Location: index.php");
}

/**
 * Sandbox token
 */
MercadoPago\SDK::setAccessToken('TEST-8948539626952155-061321-a29ce4bf0c00578dba394ef90d91c230-261498730');

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->id = 1234;
$item->description = "Dispositivo móvil de Tienda e-commerce";
$item->picture_url = __DIR__ . "{$_POST['product_image']}";
$item->title = $_POST['product_title'];
$item->quantity = 1;
$item->unit_price = $_POST['product_price'];
$item->external_reference = "matibjolivera@gmail.com";

$preference->items = [$item];

$preference->payment_methods = [
    "excluded_payment_methods" => [
        [
            "id" => "amex"
        ]
    ],
    "excluded_payment_types" => [
        [
            "id" => "atm"
        ]
    ],
    "installments" => 6
];

$preference->save();

header("Location: {$preference->sandbox_init_point}");