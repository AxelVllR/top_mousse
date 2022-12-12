<?php
namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class StripeClient
 * @package App\Security
 */
class StripeClient
{
    private $config;

    /**
     * StripeClient constructor.
     * @param string $secretKey
     * @param array $config
     */
    public function __construct(string $secretKey, array $config)
    {
        \Stripe\Stripe::setApiKey($secretKey);
        $this->config = $config;
    }

    /**
     * @param UserInterface $user
     * @param int $amount
     * @param string $description
     * @param string $token
     * @return bool
     */
    public function createCharge(UserInterface $user, int $amount, string $description, string $token)
    {
        try {
            \Stripe\Charge::create([
                'amount' => $this->config['decimal'] ? $amount * 100 : $amount,
                'currency' => $this->config['currency'],
                'description' => $description,
                'source' => $token,
                'receipt_email' => $user->getEmail()
            ]);

            return true;
        } catch (\Exception $error) {
            return false;
        }
    }
}