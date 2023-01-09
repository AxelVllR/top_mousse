<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Repository\CartItemRepository;
use App\Repository\PlateRepository;
use App\Repository\ProductRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $cartItemRepository;
    private $productRepository;
    private $plateRepository;

    public function __construct(CartItemRepository $cartItemRepository, ProductRepository $productRepository, PlateRepository $plateRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->productRepository = $productRepository;
        $this->plateRepository = $plateRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/cart/items/create", name="create_cart_item", methods={"POST"})
     */
    public function createItem(Request $request): Response
    {
        $productId = $request->request->get('productId');
        $plateId = $request->request->get('plateId');
        $title = $request->request->get('title');
        $thickness = $request->request->get('thickness');
        $width = $request->request->get('width');
        $length = $request->request->get('length');
        $diameter = $request->request->get('diameter');
        $volume = $request->request->get('volume');
        $quantity = $request->request->get('quantity');
        $price = $request->request->get('price');
        $shape = $request->request->get('shape');
        $token = $request->request->get('token');

        $dimA = ($request->request->get('dimA')) ? $request->request->get('dimA') : null;
        $dimB = ($request->request->get('dimB')) ? $request->request->get('dimB') : null;
        $dimC = ($request->request->get('dimC')) ? $request->request->get('dimC') : null;
        $dimD = ($request->request->get('dimD')) ? $request->request->get('dimD') : null;

        if ($title && $volume && $quantity && $price && $shape && $this->isCsrfTokenValid('create-cart-item', $token)) {
            $manager = $this->getDoctrine()->getManager();

            $cartItem = new CartItem();
            $cartItem->setTitle($title);
            $cartItem->setThickness($thickness);
            $cartItem->setWidth(intval($width));
            $cartItem->setLength(intval($length));
            $cartItem->setDiameter(intval($diameter));
            $cartItem->setVolume($volume);
            $cartItem->setQuantity(intval($quantity));
            $cartItem->setPrice($price);
            $cartItem->setShape($shape);

            $cartItem->setA($dimA); 
            $cartItem->setB($dimB);
            $cartItem->setC($dimC);
            $cartItem->setD($dimD);


            if ($productId) {
                $product = $this->productRepository->findOneBy(['id' => $productId]);

                if ($product) {
                    if ($product->getStock() <= intval($quantity)) {
                        $this->addFlash('response', 'Le produit ' . $product->getTitle() . ' n\'est plus disponible en quantité ' . $quantity . ', il ne peut pas être ajouté à votre panier.');

                        return $this->redirectToRoute('single_product', [
                            'id' => $product->getId(),
                            'slug' => $product->getSlug()
                        ]);
                    }

                    $cartItem->setProduct($product);
                }
            }

            if ($plateId) {
                $plate = $this->plateRepository->findOneBy(['id' => $plateId]);

                if ($plate) {
                    $cartItem->setPlate($plate);
                }
            }

            if ($this->getUser()) {
                $cartItem->setUser($this->getUser());
            }

            $cartItem->setToken($_COOKIE['cart-token']);

            $manager->persist($cartItem);
            $manager->flush();
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @return Response
     * @Route("/cart", name="cart", methods={"GET"})
     */
    public function listAll(): Response
    {
        $token = (isset($_COOKIE['cart-token'])) ? strip_tags($_COOKIE['cart-token']) : null;
        $userId = ($this->getUser()) ? $this->getUser()->getId() : null;

        if (!$token) {
            $uuid = Uuid::uuid4();
            $newToken = $uuid->toString();

            setcookie('cart-token', $newToken, time() + 3600 * 24 * 30);
            return $this->redirectToRoute('cart');
        }

        $items = $this->cartItemRepository->findAttached($token, $userId);

        $totalPrice = 0;
        $totalVolume = 0;
        $total = 0;

        foreach($items as $item) {
            $totalPrice += ($item->getQuantity() * $item->getPrice());
            $totalVolume += ($item->getQuantity() * $item->getVolume());
            $total++;
        }

        return $this->render('cart/list.html.twig', [
            'current_menu' => 'cart',
            'current_user' => $this->getUser(),
            'items' => $items,
            'total_price' => $totalPrice,
            'total_volume' => $totalVolume,
            'total' => $total
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/cart/items/{id<[0-9]*>}/update", name="update_cart_item", methods={"POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $cartItem = $this->cartItemRepository->findOneBy(['id' => $id]);
        $quantity = $request->request->get('quantity');
        $token = $request->request->get('token');

        if ($cartItem && $quantity && $this->isCsrfTokenValid('update-cart-item', $token)) {
            if ($cartItem->getUser() && $this->getUser()) {
                if ($cartItem->getUser()->getId() !== $this->getUser()->getId()) {
                    return $this->redirectToRoute('cart');
                }
            }

            if ($cartItem->getToken()) {
                if ($cartItem->getToken() !== $_COOKIE['cart-token']) {
                    return $this->redirectToRoute('cart');
                }
            }

            if ($quantity <= 0) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($cartItem);
                $manager->flush();
            } else {
                $manager = $this->getDoctrine()->getManager();

                $cartItem->setQuantity($quantity);

                $manager->persist($cartItem);
                $manager->flush();
            }
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/cart/items/{id<[0-9]*>}/delete", name="delete_cart_item", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $cartItem = $this->cartItemRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($cartItem && $this->isCsrfTokenValid('delete-cart-item', $token)) {
            if ($cartItem->getUser() && $this->getUser()) {
                if ($cartItem->getUser()->getId() !== $this->getUser()->getId()) {
                    return $this->redirectToRoute('cart');
                }
            }

            if ($cartItem->getToken()) {
                if ($cartItem->getToken() !== $_COOKIE['cart-token']) {
                    return $this->redirectToRoute('cart');
                }
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($cartItem);
            $manager->flush();
        }

        return $this->redirectToRoute('cart');
    }
}