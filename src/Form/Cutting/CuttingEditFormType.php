<?php

namespace App\Form\Cutting;

use App\Entity\Cutting;
use App\Entity\Order;
use App\Form\OrderItemFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuttingEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderItems', CollectionType::class, [
                'entry_type'   => CuttingItemFormType::class,
                'label' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__order_item__',
                'attr' => [
                    'class' => 'order-items'
                ]
            ])
            ->add('cProd')
            ->add('density')
            ->add('height')
            ->add('submit', SubmitType::class, [
                    'label' => "Valider"
                ]
            );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cutting::class,
        ]);
    }
}