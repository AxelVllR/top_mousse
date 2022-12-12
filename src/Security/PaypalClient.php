<?php

namespace App\Security;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PHPUnit\Exception;

class PaypalClient
{
    /**
     * @return PayPalHttpClient
     */
    private function client(): PayPalHttpClient
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * @return SandboxEnvironment
     */
    private function environment(): SandboxEnvironment
    {
        $clientId = 'AciBPF7uk-MA3SkxjToMNi2CmL6u59y2ChjIzM_Cb0gjnUZgBqXMfnL3oC1lOfb1JAsoQia_EtUv4qbP';
        $clientSecret = 'ECrJKm2qRgZ53qbTGVfSXlEDObuZI_vaw8av3Nm74621TW8rLTRsa8N0rd3TDFhMyd17GAsmHOngilVU';
        return new SandboxEnvironment($clientId, $clientSecret);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function checkOrder(string $id): bool
    {
        $client = self::client();
        $response = $client->execute(new OrdersGetRequest($id));
        $status = $response->statusCode;

        if ($status === 200) {
            return true;
        } else {
            return false;
        }
    }
}