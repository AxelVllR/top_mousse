<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PackagingController extends AbstractController
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return Response
     * @Route("/admin/packaging", name="admin_list_packagings", methods={"GET"})
     */
    public function listAll(): Response
    {
        $orders = $this->orderRepository->findBy(['status' => 5]);

        return $this->render('admin/packagings/list.html.twig', [
            'current_menu' => 'packagings',
            'current_user' => $this->getUser(),
            'orders' => $orders
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/{id<[0-9]*>}/packaged", name="admin_packaged_order", methods={"POST"})
     */
    public function packagedOrder(int $id, Request $request): Response
    {
        $token = $request->request->get('token');
        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if ($order && $this->isCsrfTokenValid('packaged-order', $token)) {
            if ($order->getStatus() === 5) {
                $manager = $this->getDoctrine()->getManager();

                $order->setStatus(6);

                $manager->persist($order);
                $manager->flush();

                $this->addFlash('response', 'La commande a été marquée comme emballée.');
            }
        }

        return $this->redirectToRoute('admin_list_packagings');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @Route("/admin/orders/{id<[0-9]*>}/packages", name="admin_set_order_packages", methods={"POST"})
     */
    public function setOrderPackages(int $id, Request $request): Response
    {
        $token = $request->request->get('token');
        $packages = $request->request->get('packages');
        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if ($order && $packages && $this->isCsrfTokenValid('set-order-packages', $token)) {
            if ($order->getStatus() === 5) {
                $manager = $this->getDoctrine()->getManager();

                $order->setPackages($packages);

                $manager->persist($order);
                $manager->flush();

                $this->addFlash('response', 'La commande a été mise à jour.');
            }
        }

        return $this->redirectToRoute('admin_list_packagings');
    }
}