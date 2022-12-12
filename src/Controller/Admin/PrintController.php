<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrintController extends AbstractController
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return Response
     * @Route("/admin/prints", name="admin_list_prints", methods={"GET"})
     */
    public function listAll(): Response
    {
        $orders = $this->orderRepository->findProduction();

        foreach ($orders as $order) {
            $totalPrice = 0;
            $totalVolume = 0;

            foreach($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
                $totalVolume += ($item->getQuantity() * $item->getVolume());
            }

            if ($order->getShippingMethod() === 1) {
                $totalOrder = $totalPrice + 19;
            } else if ($order->getShippingMethod() === 2) {
                $totalOrder = $totalPrice + 9;
            } else {
                $totalOrder = $totalPrice;
            }

            $order->totalPrice = $totalOrder;
            $order->totalVolume = $totalVolume;
        }

        return $this->render('admin/prints/list.html.twig', [
            'current_menu' => 'prints',
            'current_user' => $this->getUser(),
            'orders' => $orders
        ]);
    }
}