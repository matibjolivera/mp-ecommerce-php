<?php

require __DIR__ . '/vendor/autoload.php';

if (!$_POST || !$_POST['product_title'] || !$_POST['product_price'] || !$_POST['product_image']) {
    header("Location: index.php");
}

MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398');
MercadoPago\SDK::setIntegratorId("dev_24c65fb163bf11ea96500242ac130004");


$baseSiteUrl = "https://{$_SERVER["HTTP_HOST"]}";

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->id = 1234;
$item->description = "Dispositivo móvil de Tienda e-commerce";
$item->picture_url = "{$baseSiteUrl}/{$_POST['product_image']}";
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

$preference->back_urls = [
    "success" => "{$baseSiteUrl}/success",
    "failure" => "{$baseSiteUrl}/failure",
    "pending" => "{$baseSiteUrl}/pending"
];
$preference->auto_return = "approved";

$payer = new MercadoPago\Payer();
$payer->name = "Lalo";
$payer->surname = "Landa";
$payer->email = "test_user_63274575@testuser.com";
$payer->phone = [
    "area_code" => "11",
    "number" => "22223333"
];
$payer->address = [
    "street_name" => "False",
    "street_number" => 123,
    "zip_code" => "1111"
];

$preference->payer = $payer;

$preference->save();

header("Location: {$preference->init_point}");