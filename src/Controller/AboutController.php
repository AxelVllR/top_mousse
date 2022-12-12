<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @return Response
     * @Route("/about", name="about", methods={"GET"})
     */
    public function about(): Response
    {
        return $this->render('static/about.html.twig', [
            'current_menu' => 'us',
            'current_user' => $this->getUser()
        ]);
    }
}