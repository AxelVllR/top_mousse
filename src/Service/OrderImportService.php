<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\ResellerOrder;
use App\Entity\ResellerOrderItem;
use App\Repository\OrderRepository;
use App\Repository\ResellerOrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;

class OrderImportService
{

    /**
     * @param ResellerOrderRepository $resellerOrderRepository
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private ResellerOrderRepository $resellerOrderRepository, private UserRepository $userRepository, private EntityManagerInterface $entityManager)
    {
    }

    public function isResseller(string $type): Boolean
    {
        if ($type === 'revendeur') {
            return true;
        }
        return false;
    }

    public function makeOrder(array $data, string $type): Boolean
    {
        if($this->isResseller($type))
        {
            try {
                $this->resellerOrder($data);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }

        if(!$this->isResseller($type))
        {
            try {
                $this->clientOrder($data);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    public function resellerOrder(array $data)
    {
        $existingResellerOrder = $this->resellerOrderRepository->findOneBy(['reference' => $data[3]]);
        $user = $this->userRepository->findOneBy(['email' => $data[21]]);
        if (!$user) return;
        if ($existingResellerOrder) {
            $resellerOrder = $existingResellerOrder;
        } else {
            $resellerOrder = new ResellerOrder();
        }

        $resellerOrder->setStatus(3);
        $resellerOrder->setCompany($data[4]);
        $resellerOrder->setEmail($data[21]);
        $resellerOrder->setPhone($data[20]);
        $resellerOrder->setBillingAddress($user->getAddress());
        $resellerOrder->setBillingPostalCode($user->getPostalCode());
        $resellerOrder->setBillingCity($user->getCity());
        $resellerOrder->setShippingAddress($user->getAddress());
        $resellerOrder->setShippingPostalCode($user->getPostalCode());
        $resellerOrder->setShippingCity($user->getCity());
        $resellerOrder->setUser($user);
        $resellerOrder->setReference($data[3]);

        $this->entityManager->persist($resellerOrder);
        $this->entityManager->flush();

        $resellerOrderItem = new ResellerOrderItem();
        $resellerOrderItem->setTitle($data[5]);
        $resellerOrderItem->setQuantity(intval($data[6]));
        $resellerOrderItem->setThickness(floatval($data[7]));
        $resellerOrderItem->setWidth(floatval($data[8]));
        $resellerOrderItem->setLength(floatval($data[9]));
        $resellerOrderItem->setDiameter(floatval($data[10]));
        $resellerOrderItem->setVolume(floatval($data[11]));
        $resellerOrderItem->setResellerOrder($resellerOrder);
        $resellerOrderItem->setPrice(floatval($data[14]));
        $resellerOrderItem->setCutted(0);

        $this->entityManager->persist($resellerOrderItem);
        $this->entityManager->flush();
    }

    public function clientOrder(array $data)
    {
        $user = $this->userRepository->findOneBy(['email' => $data[21]]);
        if (!$user) return;
        $Order = new Order();
        $Order->setStatus(3);
        $Order->setCompany($data[4]);
        $Order->setEmail($data[21]);
        $Order->setPhone($data[20]);
        $Order->setBillingAddress($user->getAddress());
        $Order->setBillingPostalCode($user->getPostalCode());
        $Order->setBillingCity($user->getCity());
        $Order->setShippingAddress($user->getAddress());
        $Order->setShippingPostalCode($user->getPostalCode());
        $Order->setShippingCity($user->getCity());
        $Order->setUser($user);

        $this->entityManager->persist($Order);
        $this->entityManager->flush();

        $OrderItem = new OrderItem();
        $OrderItem->setTitle($data[5]);
        $OrderItem->setQuantity(intval($data[6]));
        $OrderItem->setThickness(floatval($data[7]));
        $OrderItem->setWidth(floatval($data[8]));
        $OrderItem->setLength(floatval($data[9]));
        $OrderItem->setDiameter(floatval($data[10]));
        $OrderItem->setVolume(floatval($data[11]));
        $OrderItem->setOrder($Order);
        $OrderItem->setPrice(floatval($data[14]));
        $OrderItem->setCutted(0);

        $this->entityManager->persist($OrderItem);
        $this->entityManager->flush();
    }

}