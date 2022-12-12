<?php

namespace App\Form;

use App\Repository\ResellerOrderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderInvoiceFormType extends AbstractType
{
    public function __construct(private ResellerOrderRepository $resellerOrderRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orders', ChoiceType::class, [
                'choices' => $this->resellerOrderRepository->findAllLimit(null),
                'choice_label' => function ($order) {
                    return $order->getCreatedAt()->format('Y-m-d H:m') . ' - ' . $order->getUser()?->getFirstName() . ' ' . $order->getUser()?->getLastName() . ' - ' . $order->getUser()?->getEmail() . ' - ' . $order->findStatus() . ' - ' . $order->findShippingMethod();
                },
                'expanded' => true,
                'multiple' => true,
            ],)
            ->add('submit', SubmitType::class, [
                    'label' => "Marquer comme soldé",
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Nothing here.
        ]);
    }
}