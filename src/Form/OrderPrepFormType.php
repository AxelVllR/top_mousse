<?php

namespace App\Form;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ResellerOrderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderPrepFormType extends AbstractType
{

    public function __construct(private OrderRepository $orderRepository, private ResellerOrderRepository $resellerOrderRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orders', ChoiceType::class, [
                'choices' => $this->orderRepository->findBy(array('status' => 3)),
                'choice_label' => function ($order) {
                    return $order->getCreatedAt()->format('Y-m-d H:m') . ' - ' . $order->getUser()?->getFirstName() . '/' . $order->getUser()?->getLastName() . ' - ' . $order->getUser()?->getEmail() . ' - ' . $order->findStatus() . ' - ' . $order->findShippingMethod();
                },
                'multiple' => true,
                'expanded' => true,
                'label' => false
            ],

            )
            ->add('resellers', ChoiceType::class, [
                'choices' => $this->resellerOrderRepository->findBy(array('status' => 3)),
                'choice_label' => function ($order) {
                    return $order->getCreatedAt()->format('Y-m-d H:m') . ' - ' . $order->getUser()?->getFirstName() . '/' . $order->getUser()?->getLastName() . ' - ' . $order->getUser()?->getEmail() . ' - ' . $order->findStatus() . ' - ' . $order->findShippingMethod();
                },
                'multiple' => true,
                'expanded' => true,
                'label' => false,
            ],

            )
            ->add('submit', SubmitType::class, [
                    'label' => "Signaler les commandes cochées comme EN PREPARATION"
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}
