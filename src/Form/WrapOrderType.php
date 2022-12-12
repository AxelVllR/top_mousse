<?php

namespace App\Form;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WrapOrderType extends AbstractType
{
    public function __construct(private OrderRepository $orderRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orders', ChoiceType::class, [
                'choices' => $this->orderRepository->findBy(array('status' => 5)),
                'choice_label' => function ($order) {
                    return $order->getCreatedAt()->format('Y-m-d H:m') . ' - ' . $order->getUser()->getFirstName() . '/' . $order->getUser()->getLastName() . ' - ' . $order->getUser()->getEmail() . ' - ' . $order->findStatus() . ' - ' . $order->findShippingMethod();
                },
                'multiple' => true,
                'expanded' => true,
                'label' => false,

            ],

            )
            ->add('submit', SubmitType::class, [
                    'label' => "Ajouter les lignes cochées au tableau"
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Nothing here.
        ]);
    }
}
