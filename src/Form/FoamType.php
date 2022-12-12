<?php

namespace App\Form;

use App\Entity\Foam;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FoamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('line', ChoiceType::class, [
                'empty_data' => null,
                'required' => true,
                'choices' => [
                    '0 - Mousse calage' => 0,
                    '1 - Mousse polyéther' => 1,
                    '2 - Haute résilience' => 2,
                    '3 - Mousse bultex' => 3,
                    '4 - Haute résilience' => 4,
                    '6 - Mousse dryfeel' => 6,
                    '7 - Mousse pour filtres' => 7
                ]
            ])
            ->add('comfort', ChoiceType::class, [
                'empty_data' => null,
                'required' => false,
                'choices' => [
                    '1 - Souple' => 1,
                    '2 - Médium' => 2,
                    '3 - Ferme' => 3,
                    '4 - Très ferme' => 4
                ]
            ])
            ->add('density', ChoiceType::class, [
                'empty_data' => null,
                'required' => false,
                'choices' => [
                    'Faible' => 1,
                    'Moyenne' => 2,
                    'Forte' => 3
                ]
            ])
            ->add('various', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('mattress', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('cake', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('sitting', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('back', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('cuff', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('pillow', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('cap', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('wedging', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('footstool', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('priceCube', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('priceCylinder', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('resellerPriceHt', NumberType::class, [
                'label' => 'Prix revendeur HT',
                'empty_data' => null,
                'required' => true
            ])
            ->add('resellerPrice', NumberType::class, [
                'label' => 'Prix revendeur TTC',
                'empty_data' => null,
                'required' => true
            ])
            ->add('promo', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Foam::class,
        ]);
    }
}
