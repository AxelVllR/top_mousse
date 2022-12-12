<?php

namespace App\Controller\Admin;

use App\Entity\Foam;
use App\Form\FoamType;
use App\Repository\FoamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoamController extends AbstractController
{
    private $foamRepository;

    public function __construct(FoamRepository $foamRepository)
    {
        $this->foamRepository = $foamRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/foams/create", name="admin_create_foam", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $foam = new Foam();
        $form = $this->createForm(FoamType::class, $foam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $foam->setVarious(($form->get('various')->getData()) == true ? 1 : 0);
            $foam->setMattress(($form->get('mattress')->getData()) == true ? 1 : 0);
            $foam->setCake(($form->get('cake')->getData()) == true ? 1 : 0);
            $foam->setSitting(($form->get('sitting')->getData()) == true ? 1 : 0);
            $foam->setBack(($form->get('back')->getData()) == true ? 1 : 0);
            $foam->setCuff(($form->get('cuff')->getData()) == true ? 1 : 0);
            $foam->setPillow(($form->get('pillow')->getData()) == true ? 1 : 0);
            $foam->setCap(($form->get('cap')->getData()) == true ? 1 : 0);
            $foam->setWedging(($form->get('wedging')->getData()) == true ? 1 : 0);
            $foam->setFootstool(($form->get('footstool')->getData()) == true ? 1 : 0);
            $foam->setPromo(($form->get('promo')->getData()) == true ? 1 : 0);

            $manager->persist($foam);
            $manager->flush();

            $this->addFlash('response', 'La mousse à la découpe a été ajoutée.');
            return $this->redirectToRoute('admin_list_foams');
        }

        return $this->render('admin/foams/form.html.twig', [
            'current_menu' => 'foams',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'action' => 'Ajouter'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/foams", name="admin_list_foams", methods={"GET"})
     */
    public function listAll(): Response
    {
        $foams = $this->foamRepository->findAll();

        return $this->render('admin/foams/list.html.twig', [
            'current_menu' => 'foams',
            'current_user' => $this->getUser(),
            'foams' => $foams
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/foams/{id<[0-9]*>}", name="admin_update_foam", methods={"GET", "POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $foam = $this->foamRepository->findOneBy(['id' => $id]);

        if (!$foam) {
            return $this->redirectToRoute('admin_list_foams');
        }

        $form = $this->createForm(FoamType::class, $foam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $foam->setVarious(($form->get('various')->getData()) == true ? 1 : 0);
            $foam->setMattress(($form->get('mattress')->getData()) == true ? 1 : 0);
            $foam->setCake(($form->get('cake')->getData()) == true ? 1 : 0);
            $foam->setSitting(($form->get('sitting')->getData()) == true ? 1 : 0);
            $foam->setBack(($form->get('back')->getData()) == true ? 1 : 0);
            $foam->setCuff(($form->get('cuff')->getData()) == true ? 1 : 0);
            $foam->setPillow(($form->get('pillow')->getData()) == true ? 1 : 0);
            $foam->setCap(($form->get('cap')->getData()) == true ? 1 : 0);
            $foam->setWedging(($form->get('wedging')->getData()) == true ? 1 : 0);
            $foam->setFootstool(($form->get('footstool')->getData()) == true ? 1 : 0);
            $foam->setPromo(($form->get('promo')->getData()) == true ? 1 : 0);

            $manager->persist($foam);
            $manager->flush();

            $this->addFlash('response', 'La mousse à la découpe a été modifiée.');
            return $this->redirectToRoute('admin_list_foams');
        }

        return $this->render('admin/foams/form.html.twig', [
            'current_menu' => 'foams',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'foam' => $foam,
            'action' => 'Modifier'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/foams/{id<[0-9]*>}/delete", name="admin_delete_foam", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $foam = $this->foamRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($foam && $token) {
            if ($this->isCsrfTokenValid('delete-foam', $token)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($foam);
                $manager->flush();

                $this->addFlash('response', 'La mousse à la découpe a été supprimée.');
            }
        }

        return $this->redirectToRoute('admin_list_foams');
    }

    #[Route("/admin/foams/prices", name:"admin_price_foam")]
    public function changeFoamPriceReseller(){

        return $this->render('admin/foams/prices.html.twig', [
            'current_menu' => 'foams',
            'current_user' => $this->getUser(),
            'foams' => $this->foamRepository->findAll()
        ]);
    }
}