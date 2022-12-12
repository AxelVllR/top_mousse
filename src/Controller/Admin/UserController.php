<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\ResellerType;
use App\Form\SearchUserType;
use App\Form\UpdateShippingAddressType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $userRepository;
    private $encoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/users/create", name="admin_create_user", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(ResellerType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $user->setPassword($this->encoder->encodePassword($user, $form->get('password')->getData()));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('response', 'Le compte utilisateur a été créé.');
            return $this->redirectToRoute('admin_list_users');
        }

        return $this->render('admin/users/form.html.twig', [
            'current_menu' => 'users',
            'current_user' => $this->getUser(),
            'form' => $form->createView(),
            'action' => 'Ajouter'
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/users", name="admin_list_users", methods={"GET", "POST"})
     */
    public function listAll(Request $request): Response
    {
        $form = $this->createForm(SearchUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $this->userRepository->search($form->get('search')->getData());
        } else {
            $users = $this->userRepository->findAll();
        }

        return $this->render('admin/users/list.html.twig', [
            'current_menu' => 'users',
            'current_user' => $this->getUser(),
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/users/{id<[0-9]*>}/update", name="admin_update_user", methods={"GET", "POST"})
     */
    public function update(int $id, Request $request): Response
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if ($user) {
            $form = $this->createForm(ResellerType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();

                $user->setPassword($this->encoder->encodePassword($user, $form->get('password')->getData()));

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('response', 'Le compte utilisateur a été créé.');
                return $this->redirectToRoute('admin_list_users');
            }

            return $this->render('admin/users/form.html.twig', [
                'current_menu' => 'users',
                'current_user' => $this->getUser(),
                'form' => $form->createView(),
                'action' => 'Modifier'
            ]);
        }

        return $this->redirectToRoute('admin_list_users');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/users/{id<[0-9]*>}/delete", name="admin_delete_user", methods={"POST"})
     */
    public function delete(int $id, Request $request): Response
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $token = $request->request->get('token');

        if ($user && $this->isCsrfTokenValid('delete-user', $token)) {
            $manager = $this->getDoctrine()->getManager();

            foreach ($user->getLogs() as $log) {
                $manager->remove($log);
            }

            $manager->remove($user);
            $manager->flush();

            $this->addFlash('response', 'La fiche client a été supprimée.');
        }

        return $this->redirectToRoute('admin_list_users');
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/admin/users/{id<[0-9]*>}", name="admin_single_user", methods={"GET"})
     */
    public function listOne(int $id): Response
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if ($user) {
            return $this->render('admin/users/single.html.twig', [
                'current_menu' => 'users',
                'current_user' => $this->getUser(),
                'user' => $user
            ]);
        }

        return $this->redirectToRoute('admin_list_users');
    }

    /**
     * @param string $email
     * @return Response
     * @Route("/admin/users/email/{email}", name="admin_single_user_email", methods={"GET"})
     */
    public function listOneEmail(string $email): Response
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if(!$user) {
            return $this->redirectToRoute('admin_order_invoices');
        }
        if ($user) {
            return $this->render('admin/users/single.html.twig', [
                'current_menu' => 'users',
                'current_user' => $this->getUser(),
                'user' => $user
            ]);
        }

        return $this->redirectToRoute('admin_list_users');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/users/{id<[0-9]*>}/address/shipping", name="admin_update_user_shipping_address", methods={"GET", "POST"})
     */
    public function updateShippingAddress(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }

        $user = $this->userRepository->findOneBy(['id' => $id]);

        if ($user) {
            $form = $this->createForm(UpdateShippingAddressType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('admin_single_user', [
                    'id' => $id
                ]);
            }

            return $this->render('admin/users/shipping-address.html.twig', [
                'current_menu' => 'relai',
                'current_user' => $this->getUser(),
                'form' => $form->createView(),
                'order_id' => $id
            ]);
        }

        return $this->redirectToRoute('admin_list_users');
    }
}