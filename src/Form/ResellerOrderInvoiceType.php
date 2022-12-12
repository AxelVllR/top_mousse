<?php

namespace App\Form;

use App\Repository\ResellerOrderRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResellerOrderInvoiceType extends AbstractType
{
    public function __construct(private UserRepository $resellerUsersRepo)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateAt', DateType::class, [
                'label' => 'Depuis le',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'Jusqu\'au',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add("resellers", ChoiceType::class,[
                'label' => 'Revendeur',
               'choices' => $this->resellerUsersRepo->findBy(array('role'=>2)),
                'choice_label' => function ($user) {
                     return $user->getEmail();
                },
                'multiple' => false,
            ])
            ->add("state", ChoiceType::class,[
                'label' => 'Statut de la commande',
                'choices' => [
                    'Commandé' => 3,
                    'Réglé' => 4,
                    'Expedié' => 7,
                    'Soldé' => 8,
                ],
                'multiple' => false,
            ])
            ->add("submit", SubmitType::class, [
                'label' => "Afficher le tableau avant export"
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
