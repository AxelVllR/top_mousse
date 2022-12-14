<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateShippingAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shippingAddress', HiddenType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('shippingPostalCode', HiddenType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('shippingCity', HiddenType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('shippingCode', HiddenType::class, [
                'empty_data' => null,
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
