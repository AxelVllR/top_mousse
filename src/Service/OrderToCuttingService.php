<?php

namespace App\Service;

use App\Entity\Cutting;
use App\Entity\CuttingItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\ResellerOrder;
use App\Entity\ResellerOrderItem;
use Doctrine\ORM\EntityManagerInterface;

class OrderToCuttingService
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param Order|ResellerOrder $order
     * Change Order to Cutting Object
     * @return Cutting
     */
    public function transform(Order|ResellerOrder $order): Cutting
    {
        $cutting = new Cutting();
        $cutting->setStatus($order->getStatus());
        $cutting->setFirstName($order->getFirstName());
        $cutting->setLastName($order->getLastName())
            ->setCompany($order->getCompany())
            ->setEmail($order->getEmail())
            ->setPhone($order->getPhone())
            ->setBillingAddress($order->getBillingAddress())
            ->setBillingPostalCode($order->getBillingPostalCode())
            ->setBillingCity($order->getBillingCity())
            ->setShippingAddress($order->getShippingAddress())
            ->setShippingPostalCode($order->getShippingPostalCode())
            ->setShippingCity($order->getShippingCity())
            ->setShippingMethod($order->getShippingMethod())
            ->setShippingCode($order->getShippingCode())
            ->setCreatedAt($order->getCreatedAt())
            ->setUser($order->getUser())
            ->setPaymentMethod($order->getPaymentMethod())
            ->setShippingNumber($order->getShippingNumber())
            ->setOrderNumber($order->getOrderNumber())
            ->setPackages($order->getPackages())
            ->setOrderId($order->getId());

       if($order instanceof Order) {
           foreach ($order->getOrderItems() as $item) {
               $cuttingItem = $this->setCuttingItems($item, $cutting);
               $this->entityManager->persist($cuttingItem);
           }
       }
        if($order instanceof ResellerOrder) {
            foreach ($order->getResellerOrderItems() as $item) {
                $cuttingItem = $this->setCuttingItems($item, $cutting);
                $this->entityManager->persist($cuttingItem);
            }
        }

        return $cutting;
    }

    private function setCuttingItems(ResellerOrderItem|OrderItem $orderItem, Cutting $cutting): CuttingItem
    {
        $cuttingItem = new CuttingItem();
        $cuttingItem->setTitle($orderItem->getTitle())
            ->setVolume($orderItem->getVolume())
            ->setQuantity($orderItem->getQuantity())
            ->setPrice($orderItem->getPrice())
            ->setOrder($cutting)
            ->setPlate(null)
            ->setShape("")
            ->setThickness($orderItem->getThickness())
            ->setWidth($orderItem->getWidth())
            ->setLength($orderItem->getLength())
            ->setDiameter($orderItem->getDiameter())
            ->setCutted($orderItem->getCutted());

        if($orderItem instanceof OrderItem) {
            $cuttingItem->setProduct($orderItem->getProduct())
                ->setPlate($orderItem->getPlate() ?? null)
                ->setShape($orderItem->getShape() ?? "");
        }

        return $cuttingItem;
    }


}