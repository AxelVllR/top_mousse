<?php

namespace App\Controller;

use App\Form\ContactQuoteType;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ContactController extends AbstractController
{
    private $mailer;
    private $slugger;

    public function __construct(MailerInterface $mailer, SluggerInterface $slugger)
    {
        $this->mailer = $mailer;
        $this->slugger = $slugger;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($form->get('email')->getData())
                ->to('hello@flavien-aymonnier.fr')
                ->subject('Nouvelle demande de contact de ' . $form->get('firstName')->getData() . ' ' . $form->get('lastName')->getData())
                ->text($form->get('content')->getData());

            $thumbnail = $form->get('thumbnail')->getData();

            if ($thumbnail) {
                $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

                $thumbnail->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                $email->attachFromPath('/uploads/' . $newFilename);
            }

            $this->mailer->send($email);
            $this->addFlash('response', 'Votre message a été envoyé.');
        }

        return $this->render('static/contact.html.twig', [
            'current_menu' => 'contact',
            'current_user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/contact/quote", name="contact_quote", methods={"GET", "POST"})
     */
    public function contactQuote(Request $request): Response
    {
        $form = $this->createForm(ContactQuoteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $html = '<p>Bonjour,</p>';
            $html .= '<p>Une nouvelle demande devis vient d\'être effectuée par Mr/Mme ' . $form->get('lastName')->getData() . '</p>';
            $html .= '<p>Demande : ' . $form->get('content')->getData() . '</p>';
            $html .= '<ul>';
            $html .= '<li>Adresse email : ' . $form->get('email')->getData() . '</li>';
            $html .= '<li>Téléphone : ' . $form->get('phone')->getData() . '</li>';
            $html .= '<li>Code postal : ' . $form->get('postalCode')->getData() . '</li>';
            $html .= '<li>Destination : ' . $form->get('destination')->getData() . '</li>';
            $html .= '<li>Utilisation : ' . $form->get('using')->getData() . '</li>';
            $html .= '<li>Fréquence d\'utilisation : ' . $form->get('frequency')->getData() . '</li>';
            $html .= '<li>Forme : ' . $form->get('shape')->getData() . '</li>';
            $html .= '<li>Niveau de confort : ' . $form->get('comfort')->getData() . '</li>';
            $html .= '<li>Quantité : ' . $form->get('quantity')->getData() . '</li>';
            $html .= '<li>Épaisseur/Hauteur (cm) : ' . $form->get('thickness')->getData() . '</li>';
            $html .= '<li>Largeur (cm) : ' . $form->get('width')->getData() . '</li>';
            $html .= '<li>Longueur (cm) : ' . $form->get('thickness')->getData() . '</li>';
            $html .= '</ul>';

            $email = (new Email())
                ->from($form->get('email')->getData())
                ->to('hello@flavien-aymonnier.fr')
                ->subject('Nouvelle demande de devis de ' . $form->get('lastName')->getData())
                ->html($html);

            $thumbnail = $form->get('thumbnail')->getData();

            if ($thumbnail) {
                $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

                $thumbnail->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                $email->attachFromPath('/uploads/' . $newFilename);
            }

            $this->mailer->send($email);
            $this->addFlash('response', 'Votre demande de devis a été envoyée.');
        }

        return $this->render('static/contact-quote.html.twig', [
            'current_menu' => 'contact',
            'current_user' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }
}