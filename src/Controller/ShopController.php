<?php

namespace App\Controller;

use App\Repository\PlateRepository;
use App\Repository\ProductRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    private $plateRepository;
    private $productRepository;

    public function __construct(PlateRepository $plateRepository, ProductRepository $productRepository)
    {
        $this->plateRepository = $plateRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @return Response
     * @Route("/shop", name="shop", methods={"GET"})
     */
    public function listAll(): Response
    {
        $plates = $this->plateRepository->findBy(['draft' => 0]);
        $promotedProducts = $this->productRepository->findBy([
            'bestSeller' => 1,
            'draft' => 0
        ]);
        $products = $this->productRepository->findBy([
            'bestSeller' => 0,
            'draft' => 0
        ]);

        return $this->render('shop/list.html.twig', [
            'current_menu' => 'shop',
            'current_user' => $this->getUser(),
            'plates' => $plates,
            'promoted_products' => $promotedProducts,
            'products' => $products
        ]);
    }

    /**
     * @param string $slug
     * @param int $id
     * @return Response
     * @Route("/products/{id<[0-9]*>}-{slug<[a-z0-9-]*>}", name="single_product", methods={"GET"})
     */
    public function listOne(string $slug, int $id): Response
    {
        $product = $this->productRepository->findOneBy([
            'id' => $id,
            'draft' => 0
        ]);

        if (!$product) {
            return $this->redirectToRoute('shop');
        }

        if ($slug !== $product->getSlug()) {
            return $this->redirectToRoute('single_product', [
                'id' => $product->getId(),
                'slug' => $product->getSlug()
            ]);
        }

        $token = (isset($_COOKIE['cart-token'])) ? strip_tags($_COOKIE['cart-token']) : null;

        if (!$token) {
            $uuid = Uuid::uuid4();
            $newToken = $uuid->toString();

            setcookie('cart-token', $newToken, time() + 3600 * 24 * 30);
            return $this->redirectToRoute('single_product', [
                'id' => $product->getId(),
                'slug' => $product->getSlug()
            ]);
        }

        $plates = $this->plateRepository->findBy(['draft' => 0]);
        $promotedProducts = $this->productRepository->findBy([
            'bestSeller' => 1,
            'draft' => 0
        ]);
        $products = $this->productRepository->findBy([
            'bestSeller' => 0,
            'draft' => 0
        ]);

        return $this->render('shop/single.html.twig', [
            'current_menu' => 'shop',
            'current_user' => $this->getUser(),
            'plates' => $plates,
            'promoted_products' => $promotedProducts,
            'products' => $products,
            'product' => $product
        ]);
    }
}