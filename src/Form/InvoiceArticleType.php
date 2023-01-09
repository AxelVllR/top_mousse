<?php

namespace App\Form;

use App\Entity\InvoiceArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shape', ChoiceType::class,[
                'label' => 'Forme',
                'choices' => [
                    'Cube' => 'Cube',
                    'Cylindre' => 'Cylindre',
                    'Article boutique' => 'Article boutique',
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('useCase', ChoiceType::class,[
                'label' => 'Utilité',
                'choices' => [
                    'Divers' => 'Divers',
                    'Matelas' => 'Matelas',
                    'Galette' => 'Galette',
                    'Assise' => 'Assise',
                    'Dos' => 'Dos',
                    'Manchette' => 'Manchette',
                    'Coussin' => 'Coussin',
                    'Calotte' => 'Calotte',
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('ref', TextType::class,[
                'label' => 'Référence',
                'attr' => [
                    'placeholder' => 'Référence',
                    'class' => 'form-control'
                ],
            ])
            ->add('quantity', NumberType::class,[
                'label' => 'Quantité',
                'attr' => [
                    'placeholder' => 'Quantité',
                    'class' => 'form-control'
                ],
            ])
            ->add('height', NumberType::class,[
                'label' => 'Hauteur',
                'attr' => [
                    'placeholder' => 'Hauteur',
                    'class' => 'form-control'
                ],
            ])
            ->add('length', NumberType::class,[
                'label' => 'Largeur',
                'attr' => [
                    'placeholder' => 'Largeur',
                    'class' => 'form-control'
                ],
            ])
            ->add('longueur', NumberType::class,[
                'label' => 'Longueur',
                'attr' => [
                    'placeholder' => 'Longueur',
                    'class' => 'form-control'
                ],
            ])
            ->add('diametre', NumberType::class,[
                'label' => 'Diamètre',
                'attr' => [
                    'placeholder' => 'Diamètre',
                    'class' => 'form-control'
                ],
            ])
            ->add('volume', NumberType::class,[
                'label' => 'Volume',
                'attr' => [
                    'placeholder' => 'Volume',
                    'class' => 'form-control'
                ],
            ])
            ->add('priceHt', NumberType::class,[
                'label' => 'Prix HT en €',
                'attr' => [
                    'placeholder' => 'Prix HT',
                    'class' => 'form-control'
                ],
            ])
            ->add('priceTtc', NumberType::class,[
                'label' => 'Prix TTC en €',
                'attr' => [
                    'placeholder' => 'Prix TTC',
                    'class' => 'form-control'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvoiceArticle::class,
        ]);
    }
}
