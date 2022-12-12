<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\RelayPointDB;
use App\Entity\ResellerOrder;
use App\Entity\Wrap;

class OrderToRelayService
{

    /**
     * @param OrderItem $order
     * Change Order to RelayPointDb Object
     * @return RelayPointDB
     */
    public function transform(OrderItem $order): RelayPointDB
    {
        $rpdb = new RelayPointDB();
        $rpdb->setTwo($order->getOrder()->getOrderNumber().$order->getOrder()->getCreatedAt()->format('Ymd'));
        $rpdb->setThree($order->getOrder()->getFirstName().$order->getOrder()->getLastName());
        $rpdb->setFive($order->getOrder()->getCompany());
        $rpdb->setSeven($order->getOrder()->getShippingCity());
        $rpdb->setEight($order->getOrder()->getShippingPostalCode());
        $rpdb->setNine("FR");
        $rpdb->setTen($order->getOrder()->getPhone());
        $rpdb->setTwelve($order->getOrder()->getEmail());
        $rpdb->setEighteen("FR");
        $rpdb->setTwenty("FR");

        return $rpdb;
    }
}