<?php

namespace App\Form\Admin;

use App\Entity\Ateliers\Participants;
use App\Entity\Ateliers\DatesAteliers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ParticipantsAdminType extends AbstractType
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
            'label' => false,
            'choices' => $atelier->getDatesDisponibles(),
            'choice_label' => function(DatesAteliers $date) {
                return $date->getDate()->format('d/m/Y H:i');
            },
            'placeholder' => 'Modifier la date pour le participant : ',
            'attr' => [
                'class' => 'form-control'
            ],
            'required' => true,

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
