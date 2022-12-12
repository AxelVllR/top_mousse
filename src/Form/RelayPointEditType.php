<?php

namespace App\Form;

use App\Entity\RelayPointDB;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelayPointEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('one', TextType::class, [
                'label' => '1',
                'required' => false,
            ])
            ->add('two', TextType::class, [
                'label' => '2',
                'required' => false,
            ])
            ->add('three', TextType::class, [
                'label' => '3',
                'required' => false,
            ])
            ->add('four', TextType::class, [
                'label' => '4',
                'required' => false,
            ])
            ->add('five', TextType::class, [
                'label' => '5',
                'required' => false,
            ])
            ->add('six', TextType::class, [
                'label' => '6',
                'required' => false,
            ])
            ->add('seven', TextType::class, [
                'label' => '7',
                'required' => false,
            ])
            ->add('eight', TextType::class, [
                'label' => '8',
                'required' => false,
            ])
            ->add('nine', TextType::class, [
                'label' => '9',
                'required' => false,
            ])
            ->add('ten', TextType::class, [
                'label' => '10',
                'required' => false,
            ])
            ->add('eleven', TextType::class, [
                'label' => '11',
                'required' => false,
            ])
            ->add('twelve', TextType::class, [
                'label' => '12',
                'required' => false,
            ])
            ->add('thirteen', TextType::class, [
                'label' => '13',
                'required' => false,
            ])
            ->add('fourteen', TextType::class, [
                'label' => '14',
                'required' => false,
            ])
            ->add('fifteen', TextType::class, [
                'label' => '15',
                'required' => false,
            ])
            ->add('sixteen', TextType::class, [
                'label' => '16',
                'required' => false,
            ])
            ->add('seventeen', TextType::class, [
                'label' => '17',
                'required' => false,
            ])
            ->add('eighteen', TextType::class, [
                'label' => '18',
                'required' => false,
            ])
            ->add('nineteen',TextType::class, [
                'label' => 'Mode de livraison',
                'required' => false,
            ])
            ->add('twenty', TextType::class, [
                'label' => '20',
                'required' => false,
            ])
            ->add('twentyone', TextType::class, [
                'label' => '21',
                'required' => false,
            ])
            ->add('twentytwo',TextType::class, [
                'label' => 'Poids',
                'required' => false,
            ])
            ->add('twentythree',TextType::class, [
                'label' => 'Longueur',
                'required' => false,
            ])
            ->add('twentyfour',TextType::class, [
                'label' => 'Valeur',
                'required' => false,
            ])
            ->add('twentyfive', TextType::class, [
                'label' => '25',
                'required' => false,
            ])
            ->add('twentysix', TextType::class, [
                'label' => '26',
                'required' => false,
            ])
            ->add('twentyseven', TextType::class, [
                'label' => '27',
                'required' => false,
            ])
            ->add('twentyeight', TextType::class, [
                'label' => '28',
                'required' => false,
            ])
            ->add('twentynine', TextType::class, [
                'label' => '29',
                'required' => false,
            ])
            ->add('thirty', TextType::class, [
                'label' => '30',
                'required' => false,
            ])
            ->add('thirtyone', TextType::class, [
                'label' => '31',
                'required' => false,
            ])
            ->add('thirtytwo', TextType::class, [
                'label' => '32',
                'required' => false,
            ])
            ->add('thirtythree', TextType::class, [
                'label' => '33',
                'required' => false,
            ])
            ->add('thirtyfour', TextType::class, [
                'label' => '34',
                'required' => false,
            ])
            ->add('thirtyfive',TextType::class, [
                'label' => 'Reference',
                'required' => false,
            ])
            ->add('thirtysix',  TextType::class, [
                'label' => '36',
                'required' => false,
            ])
            ->add('thirtyseven', TextType::class, [
                'label' => '37',
                'required' => false,
            ])
            ->add('thirtyeight', TextType::class, [
                'label' => '38',
                'required' => false,
            ])
            ->add('thirtynine', TextType::class, [
                'label' => '39',
                'required' => false,
            ])
            ->add('forty', TextType::class, [
                'label' => '40',
                'required' => false,
            ])
            ->add('fortyone', TextType::class, [
                'label' => '41',
                'required' => false,
            ])
            ->add('fortytwo', TextType::class, [
                'label' => '42',
                'required' => false,
            ])
            ->add('fortythree', TextType::class, [
                'label' => '43',
                'required' => false,
            ])
            ->add('fortyfour', TextType::class, [
                'label' => '44',
                'required' => false,
            ])
            ->add('Modifier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RelayPointDB::class,
        ]);
    }
}
