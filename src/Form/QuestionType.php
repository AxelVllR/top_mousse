<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'empty_data' => null,
                'required' => true,
                'label' => 'Texte de la question'
            ])
            ->add('content', TextareaType::class, [
                'empty_data' => null,
                'required' => true,
                'label' => 'Texte de la réponse'
            ])
            ->add('display', NumberType::class, [
                'empty_data' => null,
                'required' => true,
                'label' => 'Rang d\'affichage pour cette question'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
