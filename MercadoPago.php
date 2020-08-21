<?php

require __DIR__ . '/vendor/autoload.php';

use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;

class MercadoPago
{
    private const ACCESS_TOKEN = "APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398";
    private const INTEGRATOR_ID = "dev_24c65fb163bf11ea96500242ac130004";

    public function configureSdk(): void
    {
        MercadoPago\SDK::setAccessToken(self::ACCESS_TOKEN);
        MercadoPago\SDK::setIntegratorId(self::INTEGRATOR_ID);
    }

    /**
     * @return string
     */
    private function getBaseSiteUrl(): string
    {
        return "https://{$_SERVER["HTTP_HOST"]}";
    }

    /**
     * @param array $productData
     * @return Item
     */
    private function buildItem(array $productData): Item
    {
        $item = new Item();
        $item->id = 1234;
        $item->description = "Dispositivo móvil de Tienda e-commerce";
        $item->picture_url = "{$this->getBaseSiteUrl()}/{$productData['product_image']}";
        $item->title = $productData['product_title'];
        $item->quantity = 1;
        $item->unit_price = $productData['product_price'];
        return $item;
    }

    /**
     * @return string[][]
     */
    private function buildExcludedPaymentMethods(): array
    {
        return [
            [
                "id" => "amex"
            ]
        ];
    }

    /**
     * @return string[][]
     */
    private function buildExcludedPaymentTypes(): array
    {
        return [
            [
                "id" => "atm"
            ]
        ];
    }

    /**
     * @return string[]
     */
    private function buildBackUrls(): array
    {
        $baseSiteUrl = $this->getBaseSiteUrl();
        return [
            "success" => "{$baseSiteUrl}/successful_payment.php",
            "failure" => "{$baseSiteUrl}/failed_payment.php",
            "pending" => "{$baseSiteUrl}/pending_payment.php"
        ];
    }

    /**
     * @return Payer
     */
    private function buildPayer(): Payer
    {
        $payer = new Payer();
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
        return $payer;
    }

    /**
     * @return array
     */
    private function buildPaymentMethods(): array
    {
        return [
            "excluded_payment_methods" => $this->buildExcludedPaymentMethods(),
            "excluded_payment_types" => $this->buildExcludedPaymentTypes(),
            "installments" => 6
        ];
    }

    /**
     * @param array $productData
     * @return Preference
     * @throws Exception
     */
    public function createPreference(array $productData): Preference
    {
        $preference = new Preference();

        $preference->external_reference = "matibjolivera@gmail.com";
        $preference->notification_url = $this->getBaseSiteUrl() . "/payment_notification.php";

        $preference->items = [$this->buildItem($productData)];

        $preference->payment_methods = $this->buildPaymentMethods();

        $preference->back_urls = $this->buildBackUrls();
        $preference->auto_return = "approved";

        $preference->payer = $this->buildPayer();

        $preference->save();

        return $preference;
    }
}