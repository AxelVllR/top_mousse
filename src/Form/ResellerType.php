<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResellerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('lastName', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('password', PasswordType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('role', ChoiceType::class, [
                'empty_data' => null,
                'required' => true,
                'choices' => [
                    'Utilisateur' => 1,
                    'Revendeur' => 2,
                    'Administrateur' => 99
                ]
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
            ->add('country', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('phone', TextType::class, [
                'empty_data' => null,
                'required' => true
            ]) ->add('entreprise', TextType::class, [
                'empty_data' => null,
            ])
            ->add('siret', TextType::class, [
                'empty_data' => null,
            ])
            ->add('numero_tva', TextType::class, [
                'empty_data' => null,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
