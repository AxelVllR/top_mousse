<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitePlanController extends AbstractController
{
    #[Route('/site/plan', name: 'site_plan')]
    public function index(): Response
    {
        return $this->render('site_plan/index.html.twig', [
            'current_user' => $this->getUser(),
            'current_menu' => 'plan du site',
        ]);
    }
}
