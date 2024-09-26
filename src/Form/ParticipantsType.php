<?php

namespace App\Form;

use App\Entity\Ateliers\Participants;
use App\Entity\Ateliers\DatesAteliers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'class' => 'form-control',
                'placeholder' => 'Email',
            ],
            'required' => true,
        ])
        ->add('dateDisponible', EntityType::class, [
            'class' => DatesAteliers::class,
            'label' => 'Sélectionner une date disponible',
            'choices' => $atelier->getDatesDisponibles(),
            'choice_label' => function(DatesAteliers $date) {
                return $date->getDate()->format('d/m/Y H:i');
            },
            'placeholder' => 'Choisir une date : ',
            'attr' => [
                'class' => 'form-control'
            ],
            'required' => true,

        ])
        ->add('Inscription', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
            'atelier' => null,
            
        ]);
    }
}
