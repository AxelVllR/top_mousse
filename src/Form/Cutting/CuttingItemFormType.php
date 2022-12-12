<?php

namespace App\Form\Cutting;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\CuttingItem;

class CuttingItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('volume', NumberType::class, [
                'attr' => [
                    'class' => 'volume'
                ]
            ])
            ->add('quantity', NumberType::class, [
                'attr' => [
                    'class' => 'volume'
                ]
            ])
            ->add('shape', TextType::class, [
                'attr' => [
                    'class' => 'volume'
                ]
            ])
            ->add('thickness', NumberType::class, [
                'attr' => [
                    'class' => 'volume'
                ]
            ])
            ->add('width', NumberType::class, [
                'attr' => [
                    'class' => 'volume'
                ]
            ])
            ->add('length', NumberType::class, [
                'attr' => [
                    'class' => 'volume'
                ]
            ])
            ->add('diameter', NumberType::class, [
                'attr' => [
                    'class' => 'volume'
                ]
            ])
            ->add('quality', TextType::class, [
                'attr' => [
                    'class' => 'volume'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CuttingItem::class,
        ));
    }
}