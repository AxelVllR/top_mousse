<?php

namespace App\Form;

use App\Repository\OrderRepository;
use App\Repository\ResellerOrderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderResellerEndType extends AbstractType
{
    public function __construct(private ResellerOrderRepository $resellerOrderRepository, private OrderRepository $orderRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('orders', ChoiceType::class, [
            'choices' => array_merge($this->resellerOrderRepository->findBy(array('status' => 7)), $this->orderRepository->findBy(array('status' => 7))),
            'choice_label' => function ($order) {
                return $order->getCreatedAt()->format('Y-m-d H:m') . ' - ' . $order->getCompany() . ' - ' . $order->getEmail() . ' - ' . $order->findStatus() . ' - ';
            },
            'multiple' => true,
            'expanded' => true,
            'label' => false,
        ],

        )
            ->add('submit', SubmitType::class, [
                    'label' => "Solder les commandes cochées"
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
