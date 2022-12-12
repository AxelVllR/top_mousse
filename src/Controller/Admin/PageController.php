<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PageController extends AbstractController
{
    private $pageRepository;
    private $slugger;

    public function __construct(PageRepository $pageRepository, SluggerInterface $slugger)
    {
        $this->pageRepository = $pageRepository;
        $this->slugger = $slugger;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/pages/create", name="admin_create_page", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $page->setSlug(strtolower($this->slugger->slug($form->get('title')->getData())));

            $manager->persist($page);
            $manager->flush();

            $this->addFlash('response', 'La page a été ajoutée.');
            return $this->redirectToRoute('admin_list_pages');
        }

        return $this->render('admin/pages/form.html.twig', [
            'current_menu' => 'pages',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'action' => 'Ajouter'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/pages", name="admin_list_pages", methods={"GET"})
     */
    public function listAll(): Response
    {
        $pages = $this->pageRepository->findAll();

        return $this->render('admin/pages/list.html.twig', [
            'current_menu' => 'pages',
            'current_user' => $this->getUser(),
            'pages' => $pages
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/pages/{id<[0-9]*>}", name="admin_update_page", methods={"GET", "POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $page = $this->pageRepository->findOneBy(['id' => $id]);

        if (!$page) {
            return $this->redirectToRoute('admin_list_pages');
        }

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $page->setSlug(strtolower($this->slugger->slug($form->get('title')->getData())));

            $manager->persist($page);
            $manager->flush();

            $this->addFlash('response', 'La page a été modifiée.');
            return $this->redirectToRoute('admin_list_pages');
        }

        return $this->render('admin/pages/form.html.twig', [
            'current_menu' => 'pages',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'page' => $page,
            'action' => 'Modifier'
        ]);
    }

    /**
     * @return Response
     * @Route("/admin/pages/{id<[0-9]*>}/delete", name="admin_delete_page", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $page = $this->pageRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($page && $token) {
            if ($this->isCsrfTokenValid('delete-page', $token)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($page);
                $manager->flush();

                $this->addFlash('response', 'La page a été supprimée.');
            }
        }

        return $this->redirectToRoute('admin_list_pages');
    }
}