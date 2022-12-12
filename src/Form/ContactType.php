<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'empty_data' => null,
                'required' => true,
                'label' => 'Votre prénom :'
            ])
            ->add('lastName', TextType::class, [
                'empty_data' => null,
                'required' => true,
                'label' => 'Votre nom :'
            ])
            ->add('email', EmailType::class, [
                'empty_data' => null,
                'required' => true,
                'label' => 'Votre adresse mail :'
            ])
            ->add('content', TextareaType::class, [
                'empty_data' => null,
                'required' => true,
                'label' => 'Votre message :'
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
            // Configure your form options here
        ]);
    }
}
