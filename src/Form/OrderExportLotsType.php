<?php

namespace App\Form;

use App\Repository\OrderRepository;
use App\Repository\ResellerOrderRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderExportLotsType extends AbstractType
{

    public function __construct(private OrderRepository $orderRepository, private ResellerOrderRepository $resellerOrderRepository)
    {
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orders', ChoiceType::class, [
                'choices' => array_merge($this->orderRepository->findAllLimit(null)),
                'choice_label' => function ($order) {
                    return $order->getCreatedAt()->format('Y-m-d H:m') . ' - ' . $order->getUser()?->getFirstName() . ' ' . $order->getUser()?->getLastName() . ' - ' . $order->getUser()?->getEmail() . ' - ' . $order->findStatus().' - ' . $order->findShippingMethod();
                },
                'expanded' => true,
                'multiple' => true,
                'label' => false,
            ],

            )
            ->add('submit', SubmitType::class, [
                    'label' => "Valider"
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Nothing here.
        ]);
    }
}