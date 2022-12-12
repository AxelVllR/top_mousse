<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ContactQuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('phone', TextType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('postalCode', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('destination', ChoiceType::class, [
                'empty_data' => null,
                'required' => true,
                'choices' => [
                    'Maison' => 'Maison',
                    'Caravane-Camping car' => 'Caravane-Camping car',
                    'Bateau' => 'Bateau',
                    'Mousse de calage (valise...)' => 'Mousse de calage (valise...)'
                ]
            ])
            ->add('using', ChoiceType::class, [
                'empty_data' => null,
                'required' => true,
                'choices' => [
                    'Divers' => 'Divers',
                    'Matelas' => 'Matelas',
                    'Galette' => 'Galette',
                    'Assise' => 'Assise',
                    'Dos' => 'Dos',
                    'Manchette' => 'Manchette',
                    'Coussin' => 'Coussin',
                    'Calotte' => 'Calotte',
                    'Aquarium' => 'Aquarium',
                    'Pouf' => 'Pouf'
                ]
            ])
            ->add('frequency', ChoiceType::class, [
                'empty_data' => null,
                'required' => true,
                'choices' => [
                    'Fréquente' => 'Fréquente',
                    'Occasionnelle' => 'Occasionnelle'
                ]
            ])
            ->add('shape', ChoiceType::class, [
                'empty_data' => null,
                'required' => true,
                'choices' => [
                    'Parallèlipipède' => 'Parallèlipipède',
                    'Cylindre' => 'Cylindre',
                    'Découpe spéciale (schéma en PJ)' => 'Découpe spéciale (schéma en PJ)'
                ]
            ])
            ->add('comfort', ChoiceType::class, [
                'empty_data' => null,
                'required' => true,
                'choices' => [
                    'Souple' => 'Souple',
                    'Demi-ferme' => 'Demi-ferme',
                    'Ferme' => 'Ferme'
                ]
            ])
            ->add('quantity', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('thickness', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('width', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('length', NumberType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('content', TextareaType::class, [
                'empty_data' => null,
                'required' => true
            ])
            ->add('thumbnail', FileType::class, [
                'empty_data' => null,
                'required' => false,
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
                'data_class' => null,
                'label' => 'Pièce jointe :'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Nothing here.
        ]);
    }
}
