<?php

namespace App\Presentation\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-pill',
                    'placeholder' => 'Prénom'
                ],
                'required' => false,
                'label' => false
            ])
            ->add('Nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-pill',
                    'placeholder' => 'Nom de famille'
                ],
                'required' => false,
                'label' => false
            ])
            ->add('Email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control rounded-pill',
                    'placeholder' => 'Email*',
                ],
                'constraints' =>[new Assert\Email([
                    'message' => 'L\'email {{ value }} n\'est pas valide.']
                    )],
                'label' => false,
                'required' => true,
            ])
            ->add('Message', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control rounded-4',
                    'placeholder' => 'Message*'
                ],
                'constraints' => [new Assert\NotBlank(['message' => 'Le message ne peut pas etre vide.']
                )],
                'label' => false,
                'required' => true,
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-custom-color rounded-pill text-white px-4',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
