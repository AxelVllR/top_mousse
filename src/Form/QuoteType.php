<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('lastName', TextType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('company', TextType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('address', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('postalCode', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('city', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('quantity', NumberType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('thickness', NumberType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('length', NumberType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('width', NumberType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('height', NumberType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('diameter', NumberType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('price', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
