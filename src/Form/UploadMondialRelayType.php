<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UploadMondialRelayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'empty_data' => null,
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024m',
                        'mimeTypes' => [
                            'text/plain',
                            'text/csv',
                            'application/vnd.ms-excel'
                        ],
                        'mimeTypesMessage' => 'Le format du fichier envoyé est invalide, formats autorisés : .csv',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
