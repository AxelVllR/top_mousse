<?php

namespace App\Form;

use App\Repository\ResellerOrderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WrapResellerType extends AbstractType
{
    public function __construct(private ResellerOrderRepository $resellerOrderRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orders', ChoiceType::class, [
                'choices' => $this->resellerOrderRepository->findBy(array('status' => 5)),
                'choice_label' => function ($order) {
                    return $order->getCreatedAt()->format('Y-m-d H:m') . ' - ' . $order->getCompany() . ' - ' . $order->getEmail() . ' - ' . $order->findStatus() . ' - ';
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Nothing here.
        ]);
    }
}
