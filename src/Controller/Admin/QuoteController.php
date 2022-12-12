<?php

namespace App\Controller\Admin;

use App\Form\QuoteType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/quotes/create", name="admin_create_quote", methods={"GET", "POST"})
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(QuoteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstName = $form->get('firstName')->getData();
            $lastName = $form->get('lastName')->getData();
            $company = $form->get('company')->getData();
            $address = $form->get('address')->getData();
            $postalCode = $form->get('postalCode')->getData();
            $city = $form->get('city')->getData();
            $quantity = $form->get('quantity')->getData();
            $thickness = $form->get('thickness')->getData();
            $length = $form->get('length')->getData();
            $width = $form->get('width')->getData();
            $height = $form->get('height')->getData();
            $diameter = $form->get('diameter')->getData();
            $price = $form->get('price')->getData();
            $const = 0.01;

            if ($thickness && $length && $width) {
                $volume = (intval($thickness) * $const) * (intval($width) * $const) * (intval($length) * $const);
            } else {
                $volume = (intval($height) * $const) * pi() * (((intval($diameter) * $const) / 2) * ((intval($diameter) * $const) / 2));
            }

            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@topmousse.net', 'Top Mousse'))
                ->to($form->get('email')->getData())
                ->subject('Votre devis Top Mousse')
                ->htmlTemplate('emails/quotes/quote.html.twig')
                ->context([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'company' => $company,
                    'address' => $address,
                    'postalCode' => $postalCode,
                    'city' => $city,
                    'quantity' => $quantity,
                    'thickness' => $thickness,
                    'length' => $length,
                    'width' => $width,
                    'height' => $height,
                    'diameter' => $diameter,
                    'volume' => $volume,
                    'price' => $price
                ]);

            $this->mailer->send($email);
            $this->addFlash('response', 'Le devis a été envoyé.');
        }

        return $this->render('admin/quotes/form.html.twig', [
            'current_menu' => 'quotes',
            'current_user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }
}