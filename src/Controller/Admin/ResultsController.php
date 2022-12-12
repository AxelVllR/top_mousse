<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use App\Repository\ResellerOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    #[Route("/admin/results/{number}", name:"admin_results")]
    public function index(int $number, OrderRepository $orderRepository, ResellerOrderRepository $resellerOrderRepository)
    {
        $ordersData = $orderRepository->findByYear($number);
        $resellerOrders = $resellerOrderRepository->findByYear($number);

        $orders = array_merge($ordersData, $resellerOrders);


        $totalPrice = 0;
        $totalVolume = 0;
        $january = 0;
        $february = 0;
        $march = 0;
        $april = 0;
        $may = 0;
        $june = 0;
        $july = 0;
        $august = 0;
        $september = 0;
        $october = 0;
        $november = 0;
        $december = 0;



        foreach ($orders as $order) {
            foreach ($order->getOrderItems() as $item) {
                $totalPrice += ($item->getQuantity() * $item->getPrice());
                $totalVolume += ($item->getQuantity() * $item->getVolume());
            }
            if ($order->getCreatedAt()->format('m') == "01"){
                $january += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "02"){
                $february += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "03"){
                $march += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "04"){
                $april += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "05"){
                $may += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "06"){
                $june += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "07"){
                $july += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "08"){
                $august += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "09"){
                $september += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "10"){
                $october += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "11"){
                $november += ($item->getQuantity() * $item->getPrice());
            }
            if ($order->getCreatedAt()->format('m') == "12"){
                $december += ($item->getQuantity() * $item->getPrice());
            }

        }
        $total_amount = $totalPrice;
        $total_orders = count($orders);
        $total_volume = $totalVolume;


        return $this->render('admin/results/index.html.twig', [
            'total_amount' => $total_amount,
            'mean_amount' => $total_amount / 12,
            'total_orders' => $total_orders,
            'mean_orders_per_month' => $total_orders / 12,
            'mean_orders' => ($total_amount ?? 1 / $total_orders ?? 1) ?? 0,
            'total_volume' => $total_volume,
            'current_year'=>$number,
            'current_menu' => 'orders',
            'current_user' => $this->getUser(),
            'january' => $january,
            'february' => $february,
            'march' => $march,
            'april' => $april,
            'may' => $may,
            'june' => $june,
            'july' => $july,
            'august' => $august,
            'september' => $september,
            'october' => $october,
            'november' => $november,
            'december' => $december,
        ]);
    }
}