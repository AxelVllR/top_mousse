<?php

namespace App\Form;

use App\Entity\Wrap;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WrapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code de production',
                'attr' => [
                    'placeholder' => 'Code',
                ],
            ])
            ->add('number', TextType::class, [
                'label' => 'Numéro de commande',
                'attr' => [
                    'placeholder' => 'Numéro de commande',
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du client',
                'attr' => [
                    'placeholder' => 'Nom du client',
                ],
            ])
            ->add('shipping', TextType::class, [
                'label' => 'Livraison',
                'attr' => [
                    'placeholder' => 'Livraison',
                ],
            ])
            ->add('packageNumbers', TextType::class, [
                'label' => 'Nombre de colis',
                'attr' => [
                    'placeholder' => 'Nombre de colis',
                ],
            ])
            ->add('weight', TextType::class, [
                'label' => 'Poids',
                'attr' => [
                    'placeholder' => 'Poids',
                ],
            ])
            ->add('packageMaxNumbers', TextType::class, [
                'label' => 'Nombre de colis max',
                'attr' => [
                    'placeholder' => 'Nombre de colis max',
                ],
            ])
            ->add('lengthMax', TextType::class, [
                'label' => 'Longueur max',
                'attr' => [
                    'placeholder' => 'Longueur max',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wrap::class,
        ]);
    }
}
