<?php

namespace App\Presentation\Web\Form\Admin\Newsletter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => 'Objet de la newsletter',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Sujet de la newsletter',
            ],
            'required' => true,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu de la newsletter',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 10
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
