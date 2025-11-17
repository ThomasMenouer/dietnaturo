<?php

namespace App\Presentation\Web\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParticipantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $atelier = $options['atelier'];

        $builder
        ->add('email', EmailType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control mb-3',
                'placeholder' => 'Email',
            ],
            'required' => true,
        ])

        ->add('date', DateTimeType::class, [
            'data' => $atelier->getDate(),
            'widget' => 'single_text',
            'label' => 'Date de l\'inscription',
            'attr' => [
                'class' => 'form-control mb-3'
            ],
            'required' => true,
            'disabled' => true

        ])

        ->add('Inscription', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-custom-color text-white rounded-pill'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'atelier' => null,
            
        ]);
    }
}
