<?php

namespace App\Controller;

use App\Repository\PageRepository;
use App\Repository\ProductRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $pageRepository;
    private $productRepository;

    public function __construct(PageRepository $pageRepository, ProductRepository $productRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @return Response
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $page = $this->pageRepository->findOneBy([
            'slug' => 'contenu-de-la-page-d-accueil'
        ]);

        $products = $this->productRepository->findBy([
            'bestSeller' => 1,
            'draft' => 0
        ]);

        $token = (isset($_COOKIE['cart-token'])) ? strip_tags($_COOKIE['cart-token']) : null;

        if (!$token) {
            $uuid = Uuid::uuid4();
            $newToken = $uuid->toString();

            setcookie('cart-token', $newToken, time() + 3600 * 24 * 30);
            return $this->redirectToRoute('index');
        }

        return $this->render('static/home.html.twig', [
            'current_menu' => 'home',
            'current_user' => $this->getUser(),
            'content' => $page->getContent(),
            'products' => $products
        ]);
    }
}