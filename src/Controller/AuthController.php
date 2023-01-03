<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ClientType;
use App\Form\UpdateAddressType;
use App\Form\UpdateShippingAddressType;
use App\Form\UserType;
use App\Repository\CartItemRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    private $userRepository;
    private $cartItemRepository;
    private $orderRepository;

    public function __construct(UserRepository $userRepository, CartItemRepository $cartItemRepository, OrderRepository $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/signin", name="signin", methods={"GET", "POST"})
     */
    public function signIn(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/form.html.twig', [
            'current_menu' => 'account',
            'current_user' => $this->getUser(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @Route("/signup", name="signup", methods={"POST"})
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $email = $request->request->get('email');
        $token = $request->request->get('token');


        if ($this->isCsrfTokenValid('signup-account', $token)) {
            if ($email) {
                $existingUser = $this->userRepository->findOneBy(['email' => $email]);

                if (!$existingUser) {
                    $manager = $this->getDoctrine()->getManager();

                    $user = new User();
                    $user->setFirstName($request->request->get('firstName'));
                    $user->setLastName($request->request->get('lastName'));
                    $user->setEmail($request->request->get('email'));
                    $user->setPassword($encoder->encodePassword($user, $request->request->get('password')));
                    $user->setAddress($request->request->get('address'));
                    $user->setPostalCode($request->request->get('postalCode'));
                    $user->setCity($request->request->get('city'));
                    $user->setCountry($request->request->get('country'));
                    $user->setPhone($request->request->get('phone'));

                    $manager->persist($user);
                    $manager->flush();

                    $this->addFlash('response', 'Votre compte utilisateur a été créé, vous pouvez maintenant vous connecter.');
                    return $this->redirectToRoute('create_signup_log', [
                        'id' => $user->getId()
                    ]);
                } else {
                    $this->addFlash('response', 'Cette adresse email est déjà utilisée.');
                }
            }
        }

        return $this->redirectToRoute('signin');
    }

    /**
     * @Route("/signout", name="signout")
     */
    public function signOut()
    {
        // Intercepted by firewall.
    }

    /**
     * @return Response
     * @Route("/account/edit", name="account_edit", methods={"GET", "POST"})
     */
    public function editCoordinates(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $form = $this->createForm(ClientType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $this->addFlash("response", "Profil modifié");
            return $this->redirectToRoute('account');
        }

        return $this->render('account/account_edit.twig', [
            'current_menu' => 'customer',
            'current_user' => $this->getUser(),
            "form" => $form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route("/account", name="account", methods={"GET", "POST"})
     */
    public function account(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $token = (isset($_COOKIE['cart-token'])) ? strip_tags($_COOKIE['cart-token']) : null;
        $userId = ($this->getUser()) ? $this->getUser()->getId() : null;

        $items = $this->cartItemRepository->findAttached($token, $userId);
        $orders = $this->getUser()->getOrders();
        dump($orders);

        $pendingOrders = [];
        $paidOrders = [];
        $processingOrders = [];
        $cuttedOrders = [];
        $packagedOrders = [];
        $sentOrders = [];
        $soldOrders = [];

        foreach ($orders as $order) {
            switch ($order->getStatus()) {
                case 1:
                    array_push($pendingOrders, $order);
                    break;
                case 2:
                    array_push($pendingOrders, $order);
                    break;
                case 3:
                    array_push($paidOrders, $order);
                    break;
                case 4:
                    array_push($processingOrders, $order);
                    break;
                case 5:
                    array_push($cuttedOrders, $order);
                    break;
                case 6:
                    array_push($packagedOrders, $order);
                    break;
                case 7:
                    array_push($sentOrders, $order);
                    break;
                case 8:
                    array_push($soldOrders, $order);
                    break;
            }
        }

        return $this->render('account/account.html.twig', [
            'current_menu' => 'customer',
            'current_user' => $this->getUser(),
            'items' => $items,
            'orders' => $orders,
            'pending_orders' => $pendingOrders,
            'paid_orders' => $paidOrders,
            'processing_orders' => $processingOrders,
            'cutted_orders' => $cuttedOrders,
            'packaged_orders' => $packagedOrders,
            'sent_orders' => $sentOrders,
            'sold_orders' => $soldOrders
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/account/{id<[0-9]*>}/address", name="update_account_address", methods={"GET", "POST"})
     */
    public function updateAddress(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $form = $this->createForm(UpdateAddressType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($this->getUser());
            $manager->flush();

            foreach ($this->getUser()->getOrders() as $order) {
                if ($order->getStatus() === 1 && $order->getShippingMethod() === 1) {
                    $order->setBillingAddress($this->getUser()->getAddress());
                    $order->setBillingCity($this->getUser()->getCity());
                    $order->setBillingPostalCode($this->getUser()->getPostalCode());
                    $order->setShippingAddress($this->getUser()->getAddress());
                    $order->setShippingCity($this->getUser()->getCity());
                    $order->setShippingPostalCode($this->getUser()->getPostalCode());
                }

                $manager->persist($order);
                $manager->flush();
            }

            return $this->redirectToRoute('set_order_shipping', [
                'id' => $id
            ]);
        }

        return $this->render('account/address.html.twig', [
            'current_menu' => 'account',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'order_id' => $id
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/account/{id<[0-9]*>}/address/shipping", name="update_account_shipping_address", methods={"GET", "POST"})
     */
    public function updateShippingAddress(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if ($order) {
            $volume = 0;
            foreach ($order->getOrderItems() as $item) {
                $volume += ($item->getQuantity() * $item->getVolume());
            }

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

            $form = $this->createForm(UpdateShippingAddressType::class, $this->getUser());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($this->getUser());
                $manager->flush();

                foreach ($this->getUser()->getOrders() as $order) {
                    if ($order->getStatus() === 1 && $order->getShippingMethod() === 2) {
                        $order->setShippingAddress($this->getUser()->getShippingAddress());
                        $order->setShippingCity($this->getUser()->getShippingCity());
                        $order->setShippingPostalCode($this->getUser()->getShippingPostalCode());
                        $order->setShippingCode($this->getUser()->getShippingCode());
                    }

                    $manager->persist($order);
                    $manager->flush();
                }

                return $this->redirectToRoute('set_order_shipping', [
                    'id' => $id
                ]);
            }

            return $this->render('account/shipping-address.html.twig', [
                'current_menu' => 'relai',
                'current_user' => $this->getUser(),
                'form' => $form->createView(),
                'order_id' => $id,
                'volume' => $getVolume
            ]);
        }

        return $this->redirectToRoute('cart');
    }
}
