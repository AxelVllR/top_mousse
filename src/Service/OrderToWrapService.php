<?php

namespace App\Service;

use App\Entity\Cutting;
use App\Entity\CuttingItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\ResellerOrder;
use App\Entity\ResellerOrderItem;
use App\Entity\Wrap;
use Doctrine\ORM\EntityManagerInterface;

class OrderToWrapService
{
    /**
     * @param Order|ResellerOrder $order
     * Change Order to Wrap Object
     * @return Wrap
     */
    public function transform(Order|ResellerOrder $order): Wrap
    {
        $wrap = new Wrap();
        $wrap->setNumber($order->getId());
        $wrap->setCode($order->getOrderNumber());
        $wrap->setName($order->getFirstName() . " " . $order->getLastName());

        return $wrap;
    }
}