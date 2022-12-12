<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @return Response
     * @Route("/admin", name="admin", methods={"GET"})
     */
    public function home(): Response
    {
        if(!$this->getUser() || $this->getUser()->getRole() !== 99) {
            return $this->redirectToRoute('account');
        }

        return $this->render('admin/static/home.html.twig', [
            'current_menu' => 'admin',
            'current_user' => $this->getUser()
        ]);
    }
}