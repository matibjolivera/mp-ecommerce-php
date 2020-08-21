<?php

if (!$_POST || !$_POST['product_title'] || !$_POST['product_price'] || !$_POST['product_image']) {
    header("Location: index.php");
}

$mercadoPago = new MercadoPago();
$mercadoPago->configureSdk();
try {
    $preference = $mercadoPago->createPreference([
        'product_title' => $_POST['product_title'],
        'product_price' => (float)$_POST['product_price'],
        'product_image' => $_POST['product_image']
    ]);
    header("Location: {$preference->init_point}");
} catch (Exception $e) {
    echo "Error al crear el preference";
}