<?php

namespace App\Controller\Admin;

use App\Form\SearchRelaiType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RelaiController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/relai", name="admin_search_relai", methods={"GET", "POST"})
     */
    public function find(Request $request): Response
    {
        $form = $this->createForm(SearchRelaiType::class);
        $form->handleRequest($request);

        $getVolume = '24L';
        $postalCode = 59000;

        if ($form->isSubmitted() && $form->isValid()) {
            $volume = $form->get('volume')->getData();
            $postalCode = $form->get('postalCode')->getData();

            if ($volume > 0.11) {
                $getVolume = '24L';
            } else {
                $getVolume = '24R';
            }

            if ($volume > 1) {
                $getVolume = '24X';
            }

            if ($volume > 2) {
                $getVolume = 'DRI';
            }
        }

        return $this->render('admin/static/relai.html.twig', [
            'current_menu' => 'relai',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'volume' => $getVolume,
            'postal_code' => $postalCode
        ]);
    }
}