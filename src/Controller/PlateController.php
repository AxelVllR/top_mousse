<?php

namespace App\Controller;

use App\Repository\PlateRepository;
use App\Repository\ProductRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlateController extends AbstractController
{
    private $plateRepository;
    private $productRepository;

    public function __construct(PlateRepository $plateRepository, ProductRepository $productRepository)
    {
        $this->plateRepository = $plateRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $slug
     * @param int $id
     * @return Response
     * @Route("/plates/{id<[0-9]*>}-{slug<[a-z0-9-]*>}", name="single_plate", methods={"GET"})
     */
    public function listOne(string $slug, int $id): Response
    {
        $plate = $this->plateRepository->findOneBy([
            'id' => $id,
            'draft' => 0
        ]);

        if (!$plate) {
            return $this->redirectToRoute('shop');
        }

        if ($slug !== $plate->getSlug()) {
            return $this->redirectToRoute('single_plate', [
                'id' => $plate->getId(),
                'slug' => $plate->getSlug()
            ]);
        }

        $token = (isset($_COOKIE['cart-token'])) ? strip_tags($_COOKIE['cart-token']) : null;

        if (!$token) {
            $uuid = Uuid::uuid4();
            $newToken = $uuid->toString();

            setcookie('cart-token', $newToken, time() + 3600 * 24 * 30);
            return $this->redirectToRoute('single_plate', [
                'id' => $plate->getId(),
                'slug' => $plate->getSlug()
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

        return $this->render('plates/single.html.twig', [
            'current_menu' => 'shop',
            'current_user' => $this->getUser(),
            'plates' => $plates,
            'promoted_products' => $promotedProducts,
            'products' => $products,
            'plate' => $plate
        ]);
    }
}