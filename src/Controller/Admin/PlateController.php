<?php

namespace App\Controller\Admin;

use App\Entity\Plate;
use App\Form\PlateType;
use App\Repository\PlateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PlateController extends AbstractController
{
    private $plateRepository;
    private $slugger;

    public function __construct(PlateRepository $plateRepository, SluggerInterface $slugger)
    {
        $this->plateRepository = $plateRepository;
        $this->slugger = $slugger;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/plates/create", name="admin_create_plate", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $plate = new Plate();
        $form = $this->createForm(PlateType::class, $plate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $plate->setSlug(strtolower($this->slugger->slug($form->get('title')->getData())));
            $plate->setPromo(($form->get('promo')->getData()) == true ? 1 : 0);
            $plate->setDelivery(($form->get('delivery')->getData()) == true ? 1 : 0);
            $plate->setBestSeller(($form->get('bestSeller')->getData()) == true ? 1 : 0);

            $thumbnail = $form->get('thumbnail')->getData();

            if ($thumbnail) {
                $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

                $thumbnail->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                $plate->setThumbnail($newFilename);
            }

            $manager->persist($plate);
            $manager->flush();

            $this->addFlash('response', 'Le produit plaque a été ajouté.');
            return $this->redirectToRoute('admin_list_plates');
        }

        return $this->render('admin/plates/form.html.twig', [
            'current_menu' => 'plates',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'action' => 'Ajouter'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/plates", name="admin_list_plates", methods={"GET"})
     */
    public function listAll(): Response
    {
        $plates = $this->plateRepository->findAll();

        return $this->render('admin/plates/list.html.twig', [
            'current_menu' => 'plates',
            'current_user' => $this->getUser(),
            'plates' => $plates
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/plates/{id<[0-9]*>}", name="admin_update_plate", methods={"GET", "POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $plate = $this->plateRepository->findOneBy(['id' => $id]);

        if (!$plate) {
            return $this->redirectToRoute('admin_list_plates');
        }

        $form = $this->createForm(PlateType::class, $plate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $plate->setSlug(strtolower($this->slugger->slug($form->get('title')->getData())));
            $plate->setPromo(($form->get('promo')->getData()) == true ? 1 : 0);
            $plate->setDelivery(($form->get('delivery')->getData()) == true ? 1 : 0);
            $plate->setBestSeller(($form->get('bestSeller')->getData()) == true ? 1 : 0);

            $thumbnail = $form->get('thumbnail')->getData();

            if ($thumbnail) {
                $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

                $thumbnail->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                $plate->setThumbnail($newFilename);
            }

            $manager->persist($plate);
            $manager->flush();

            $this->addFlash('response', 'Le produit plaque a été modifié.');
            return $this->redirectToRoute('admin_list_plates');
        }

        return $this->render('admin/plates/form.html.twig', [
            'current_menu' => 'plates',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'plate' => $plate,
            'action' => 'Modifier'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/plates/{id<[0-9]*>}/delete", name="admin_delete_plate", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $plate = $this->plateRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($plate && $token) {
            if ($this->isCsrfTokenValid('delete-plate', $token)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($plate);
                $manager->flush();

                $this->addFlash('response', 'Le produit plaque a été supprimé.');
            }
        }

        return $this->redirectToRoute('admin_list_plates');
    }
}