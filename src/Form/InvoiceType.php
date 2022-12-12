<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\InvoiceArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class,[
                'label' => 'Numéro de facture',
                'attr' => [
                    'placeholder' => 'Numéro de facture',
                    'class' => 'form-control'
                ],
            ])
            ->add('status', ChoiceType::class,[
                'label' => 'Statut',
                'choices' => [
                    'Commandé' => 'Commandé',
                    'Réglé' => 'Réglé',
                    'Expédié' => 'Expédié',
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('name', TextType::class,[
                'label' => 'Nom, Prénom du client',
                'attr' => [
                    'placeholder' => 'Doe John',
                    'class' => 'form-control'
                ],
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'doejohn@mail.fr',
                    'class' => 'form-control'
                ],
            ])
            ->add('address', TextType::class,[
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => '1 rue de la paix',
                    'class' => 'form-control'
                ],
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Paris',
                    'class' => 'form-control'
                ],
            ])
            ->add('postalCode', TextType::class,[
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => '75000',
                    'class' => 'form-control'
                ],
            ])
            ->add('country', TextType::class,[
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'France',
                    'class' => 'form-control'
                ],
            ])
            ->add('phone', TextType::class,[
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => '0123456789',
                    'class' => 'form-control'
                ],
            ])
            ->add('payementType',   ChoiceType::class, [
                'label' => 'Type de paiement',
                'choices' => [
                    'En ligne' => 'En ligne',
                    'Chèque' => 'Chèque',
                    'Magasin' => 'Magasin',
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('shipment', ChoiceType::class,[
                'label' => 'Expédition',
                'choices' => [
                    'Domicile' => 'Domicile',
                    'Point Relay' => 'Point Relay',
                    'Non' => 'Non',
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('fee', ChoiceType::class,[
                'label' => "Frais d'expédition",
                'choices' => [
                    'Domicile = 19€' => 19,
                    'Point Relay = 9€' => 9,
                    'Non' => 0,
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('dateAt', DateType::class,[
                'label' => 'Date',
                'required' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('articles', CollectionType::class, [
                'entry_type' => InvoiceArticleType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Créer la facture',
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
