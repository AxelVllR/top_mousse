<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/pages/{id<[0-9]*>}-{slug<[a-z0-9-]*>}", name="single_page", methods={"GET"})
     */
    public function listOne(int $id, string $slug): Response
    {
        $page = $this->pageRepository->findOneBy([
            'id' => $id,
            'draft' => 0
        ]);

        if ($page) {
            if ($slug !== $page->getSlug()) {
                return $this->redirectToRoute('single_page', [
                    'id' => $page->getId(),
                    'slug' => $page->getSlug()
                ]);
            }

            return $this->render('pages/single.html.twig', [
                'current_menu' => 'pages',
                'current_user' => $this->getUser(),
                'page' => $page
            ]);
        }

        return $this->redirectToRoute('index');
    }
}