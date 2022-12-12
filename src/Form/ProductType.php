<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('title', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('thumbnail', FileType::class, [
                'empty_data' => null,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Le type de fichier envoyé est invalide, extensions autorisées : JPG, JPEG, PNG ou GIF.',
                    ])
                ],
                'data_class' => null
            ])
            ->add('volume', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('content', TextareaType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('priceTtc', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('priceHt', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('delivery', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('promo', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('bestSeller', CheckboxType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('declination', TextType::class, [
                'empty_data' => null,
                'required' => false
            ])
            ->add('stock', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('draft', ChoiceType::class, [
                'empty_data' => null,
                'required' => true,
                'choices' => [
                    'Brouillon' => 1,
                    'Publié' => 0
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
