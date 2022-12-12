<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\CartItemRepository;
use App\Repository\OrderRepository;
use App\Security\PaypalClient;
use Ramsey\Uuid\Uuid;
use App\Security\StripeClient;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $orderRepository;
    private $cartItemRepository;

    public function __construct(OrderRepository $orderRepository, CartItemRepository $cartItemRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cartItemRepository = $cartItemRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/orders/create", name="create_order", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('create-order', $token)) {
            $token = (isset($_COOKIE['cart-token'])) ? strip_tags($_COOKIE['cart-token']) : null;
            $userId = ($this->getUser()) ? $this->getUser()->getId() : null;

            $items = $this->cartItemRepository->findAttached($token, $userId);

            if (!$items) {
                return $this->redirectToRoute('cart');
            }

            $manager = $this->getDoctrine()->getManager();

            $order = new Order();
            $order->setStatus(1);
            $order->setFirstName($this->getUser()->getFirstName());
            $order->setLastName($this->getUser()->getLastName());
            $order->setEmail($this->getUser()->getEmail());
            $order->setPhone($this->getUser()->getPhone());
            $order->setBillingAddress($this->getUser()->getAddress());
            $order->setBillingPostalCode($this->getUser()->getPostalCode());
            $order->setBillingCity($this->getUser()->getCity());
            $order->setUser($this->getUser());

            foreach ($items as $item) {
                $product = $item->getProduct();
                $plate = $item->getPlate();

                $orderItem = new OrderItem();
                $orderItem->setTitle($item->getTitle());
                $orderItem->setThickness($item->getThickness());
                $orderItem->setWidth($item->getWidth());
                $orderItem->setLength($item->getLength());
                $orderItem->setDiameter($item->getDiameter());
                $orderItem->setVolume($item->getVolume());
                $orderItem->setQuantity($item->getQuantity());
                $orderItem->setPrice($item->getPrice());
                $orderItem->setShape($item->getShape());
                $orderItem->setCutted(0);

                if ($product) {
                    $orderItem->setProduct($item->getProduct());

                    if ($product->getStock() >= 1) {
                        $product->setStock($product->getStock() - $item->getQuantity());

                        $manager->persist($product);
                        $manager->flush();
                    } else {
                        $this->addFlash('response', 'Le produit ' . $product->getTitle() . ' n\'est plus disponible en quantité ' . $quantity . ', il ne peut pas être ajouté à votre panier.');

                        $manager->remove($item);
                        $manager->flush();
                    }
                }

                if ($plate) {
                    $orderItem->setPlate($item->getPlate());

                    if ($plate->getStock() >= 1) {
                        $plate->setStock($plate->getStock() - $item->getQuantity());

                        $manager->persist($plate);
                        $manager->flush();
                    } else {
                        $this->addFlash('response', 'Le produit ' . $plate->getTitle() . ' n\'est plus disponible, il a été retiré de votre panier.');

                        $manager->remove($plate);
                        $manager->flush();

                        return $this->redirectToRoute('cart');
                    }
                }

                $orderItem->setOrder($order);

                $manager->persist($orderItem);
                $manager->flush();

                $manager->remove($item);
                $manager->flush();
            }

            $manager->persist($order);
            $manager->flush();

            return $this->redirectToRoute('set_order_shipping', [
                'id' => $order->getId()
            ]);
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/orders/{id<[0-9]*>}/shipping", name="set_order_shipping", methods={"GET", "POST"})
     */
    public function setShipping(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if ($order) {
            if ($order->getUser()->getId() !== $this->getUser()->getId() || $order->getStatus() !== 1) {
                return $this->redirectToRoute('cart');
            }

            $port = $request->request->get('port');
            $token = $request->request->get('token');
            $payment = $request->request->get('payment');

            if ($port && $this->isCsrfTokenValid('set-order-shipping', $token)) {
                $manager = $this->getDoctrine()->getManager();

                if ($port === 'domicile') {
                    $order->setShippingMethod(1);
                    $order->setShippingAddress($this->getUser()->getAddress());
                    $order->setShippingCity($this->getUser()->getCity());
                    $order->setShippingPostalCode($this->getUser()->getPostalCode());
                } else if ($port === 'relais') {
                    $order->setShippingMethod(2);
                    $order->setShippingAddress($this->getUser()->getShippingAddress());
                    $order->setShippingCity($this->getUser()->getShippingCity());
                    $order->setShippingPostalCode($this->getUser()->getShippingPostalCode());
                } else {
                    $order->setShippingMethod(3);
                    $order->setShippingAddress(null);
                    $order->setShippingCity(null);
                    $order->setShippingPostalCode(null);
                }

                $manager->persist($order);
                $manager->flush();
            }

            if ($payment && $this->isCsrfTokenValid('set-order-shipping', $token)) {
                $manager = $this->getDoctrine()->getManager();

                if ($payment === 'stripe') {
                    $order->setPaymentMethod(1);
                } else if ($payment === 'paypal') {
                    $order->setPaymentMethod(2);
                } else {
                    $order->setPaymentMethod(3);
                }

                $manager->persist($order);
                $manager->flush();
            }

            $totalPrice = 0;
            $totalVolume = 0;
            $total = 0;

            foreach($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
                $totalVolume += ($item->getQuantity() * $item->getVolume());
                $total++;
            }

            return $this->render('orders/shipping.html.twig', [
                'current_menu' => 'orders',
                'current_user' => $this->getUser(),
                'order' => $order,
                'total_price' => $totalPrice,
                'total_volume' => $totalVolume,
                'total' => $total
            ]);
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/orders/{id<[0-9]*>}/checkout", name="checkout_order", methods={"GET"})
     */
    public function checkout(int $id, Request $request): Response
    {
        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        if ($order) {
            if ($order->getUser()->getId() !== $this->getUser()->getId() || $order->getStatus() !== 1) {
                return $this->redirectToRoute('cart');
            }

            if ($order->getStatus() !== 1 && ($order->getShippingMethod() == null || $order->getPaymentMethod() == null)) {
                return $this->redirectToRoute('account');
            }

            if (($order->getShippingMethod() === 1 || $order->getShippingMethod() === 2) && ($order->getShippingAddress() == '' || $order->getShippingCity() == '' || $order->getShippingPostalCode() == '')) {
                $this->addFlash('response', 'Veuillez sélectionner une adresse de livraison.');
                return $this->redirectToRoute('set_order_shipping', [
                    'id' => $order->getId()
                ]);
            }

            $totalPrice = 0;
            $totalVolume = 0;
            $total = 0;

            foreach($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
                $totalVolume += ($item->getQuantity() * $item->getVolume());
                $total++;
            }

            if ($order->getShippingMethod() === 1) {
                $totalOrder = $totalPrice + 19;
            } else if ($order->getShippingMethod() === 2) {
                $totalOrder = $totalPrice + 9;
            } else {
                $totalOrder = $totalPrice;
            }

            return $this->render('orders/checkout.html.twig', [
                'current_menu' => 'orders',
                'current_user' => $this->getUser(),
                'order' => $order,
                'total_price' => $totalPrice,
                'total_volume' => $totalVolume,
                'total_order' => $totalOrder,
                'total' => $total,
                'stripe_public_key' => $this->getParameter('stripe_public_key')
            ]);
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/orders/{id<[0-9]*>}/pay/card", name="pay_order_card", methods={"POST"})
     */
    public function payCard(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $order = $this->orderRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($order && $this->isCsrfTokenValid('pay-order-card', $token)) {
            if ($order->getUser()->getId() === $this->getUser()->getId() && $order->getStatus() === 1) {
                $totalPrice = 0;
                $totalVolume = 0;
                $total = 0;

                foreach($order->getOrderItems() as $item) {
                    $totalPrice += ($item->getQuantity() * $item->getPrice());
                    $totalVolume += ($item->getQuantity() * $item->getVolume());
                    $total++;
                }

                if ($order->getShippingMethod() === 1) {
                    $totalOrder = $totalPrice + 19;
                } else if ($order->getShippingMethod() === 2) {
                    $totalOrder = $totalPrice + 9;
                } else {
                    $totalOrder = $totalPrice;
                }

                $stripe = new StripeClient($this->getParameter('stripe_secret_key'), $this->getParameter('payment'));
                $charge = $stripe->createCharge($this->getUser(), $totalOrder, 'CMD-WEB' . $order->getId(), $request->request->get('stripe'));

                if (!$charge) {
                    $this->addFlash('response', 'Une erreur est survenue lors du paiement.');

                    return $this->redirectToRoute('checkout_order', [
                        'id' => $order->getId()
                    ]);
                }

                $manager = $this->getDoctrine()->getManager();

                $order->setStatus(3);

                $manager->persist($order);
                $manager->flush();
            }
        }

        return $this->redirectToRoute('confirmed_order_card', [
            'id' => $order->getId()
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/orders/{id<[0-9]*>}/confirmed/card", name="confirmed_order_card", methods={"GET"})
     */
    public function confirmedCard(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if ($order) {
            if ($order->getUser()->getId() === $this->getUser()->getId() && $order->getStatus() === 3) {
                $totalPrice = 0;
                $totalVolume = 0;
                $total = 0;

                foreach($order->getOrderItems() as $item) {
                    $totalPrice += ($item->getQuantity() * $item->getPrice());
                    $totalVolume += ($item->getQuantity() * $item->getVolume());
                    $total++;
                }

                if ($order->getShippingMethod() === 1) {
                    $totalOrder = $totalPrice + 19;
                } else if ($order->getShippingMethod() === 2) {
                    $totalOrder = $totalPrice + 9;
                } else {
                    $totalOrder = $totalPrice;
                }

                return $this->render('orders/confirmed-card.html.twig', [
                    'current_menu' => 'cart',
                    'current_user' => $this->getUser(),
                    'order' => $order,
                    'total_price' => $totalPrice,
                    'total_volume' => $totalVolume,
                    'total_order' => $totalOrder,
                    'total' => $total
                ]);
            }
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/orders/{id<[0-9]*>}/pay/paypal", name="pay_order_paypal", methods={"POST"})
     */
    public function payPaypal(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $order = $this->orderRepository->findOneBy(['id' => $id]);
        $transactionId = $request->request->get('paypalId');
        $token = $request->request->get('token');

        if ($order && $transactionId && $this->isCsrfTokenValid('pay-order-paypal', $token)) {
            if ($order->getUser()->getId() === $this->getUser()->getId() && $order->getStatus() === 1) {
                $paypal = new PaypalClient();
                $valid = $paypal->checkOrder($transactionId);

                if (!$valid) {
                    $this->addFlash('response', 'Une erreur est survenue lors du paiement.');

                    return $this->redirectToRoute('checkout_order', [
                        'id' => $order->getId()
                    ]);
                }

                $manager = $this->getDoctrine()->getManager();

                $order->setStatus(3);

                $manager->persist($order);
                $manager->flush();
            }
        }

        return $this->redirectToRoute('confirmed_order_paypal', [
            'id' => $order->getId()
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/orders/{id<[0-9]*>}/confirmed/paypal", name="confirmed_order_paypal", methods={"GET"})
     */
    public function confirmedPaypal(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if ($order) {
            if ($order->getUser()->getId() === $this->getUser()->getId() && $order->getStatus() === 3) {
                $totalPrice = 0;
                $totalVolume = 0;
                $total = 0;

                foreach($order->getOrderItems() as $item) {
                    $totalPrice += ($item->getQuantity() * $item->getPrice());
                    $totalVolume += ($item->getQuantity() * $item->getVolume());
                    $total++;
                }

                if ($order->getShippingMethod() === 1) {
                    $totalOrder = $totalPrice + 19;
                } else if ($order->getShippingMethod() === 2) {
                    $totalOrder = $totalPrice + 9;
                } else {
                    $totalOrder = $totalPrice;
                }

                return $this->render('orders/confirmed-paypal.html.twig', [
                    'current_menu' => 'cart',
                    'current_user' => $this->getUser(),
                    'order' => $order,
                    'total_price' => $totalPrice,
                    'total_volume' => $totalVolume,
                    'total_order' => $totalOrder,
                    'total' => $total,
                ]);
            }
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/orders/{id<[0-9]*>}/pay/bank", name="pay_order_bank", methods={"POST"})
     */
    public function payBank(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $order = $this->orderRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($order && $this->isCsrfTokenValid('pay-order-bank', $token)) {
            if ($order->getUser()->getId() === $this->getUser()->getId() && $order->getStatus() === 1) {
                $manager = $this->getDoctrine()->getManager();

                $order->setStatus(2);

                $manager->persist($order);
                $manager->flush();
            }
        }

        return $this->redirectToRoute('confirmed_order_bank', [
            'id' => $order->getId()
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/orders/{id<[0-9]*>}/confirmed/bank", name="confirmed_order_bank", methods={"GET"})
     */
    public function confirmedBank(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if ($order) {
            if ($order->getUser()->getId() === $this->getUser()->getId() && $order->getStatus() === 2) {
                $totalPrice = 0;
                $totalVolume = 0;
                $total = 0;

                foreach($order->getOrderItems() as $item) {
                    $totalPrice += ($item->getQuantity() * $item->getPrice());
                    $totalVolume += ($item->getQuantity() * $item->getVolume());
                    $total++;
                }

                if ($order->getShippingMethod() === 1) {
                    $totalOrder = $totalPrice + 19;
                } else if ($order->getShippingMethod() === 2) {
                    $totalOrder = $totalPrice + 9;
                } else {
                    $totalOrder = $totalPrice;
                }

                return $this->render('orders/confirmed-bank.html.twig', [
                    'current_menu' => 'cart',
                    'current_user' => $this->getUser(),
                    'order' => $order,
                    'total_price' => $totalPrice,
                    'total_volume' => $totalVolume,
                    'total_order' => $totalOrder,
                    'total' => $total,
                ]);
            }
        }

        return $this->redirectToRoute('cart');
    }

}