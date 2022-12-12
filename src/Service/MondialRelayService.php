<?php

namespace App\Service;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Mime\Email;

class MondialRelayService
{

    public function __construct(private EmailService $mailer)
    {
    }

    public function sendEmails(array $emails) : Boolean
    {
        if (empty($emails)) {
            return false;
        }
        foreach ($emails as $email) {
            $email = $this->mailer->createEmail('emails/orders/mondial.html.twig')
                ->to($email)
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Votre colis est arrivé en point relais Mondial Relay');
            $this->mailer->send($email);
        }
        return true;
    }



}