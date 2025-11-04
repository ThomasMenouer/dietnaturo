<?php

namespace App\Presentation\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prénom'
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Email'
                ],
            ])
            ->add('acceptPrivacy', CheckboxType::class, [
                'label' => 'J’ai lu et j’accepte la <a href="' . $options['privacy_url'] . '" target="_blank">politique de confidentialité</a>',
                'mapped' => false,
                'required' => true,
                'label_html' => true,
                'row_attr' => [
                    'class' => 'form-check', // wrapper div
                ],
                'attr' => [
                    'class' => 'form-check-input', // input
                ],
                'label_attr' => [
                    'class' => 'form-check-label', // label
                ],
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-custom-color text-white rounded-pill px-4'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'privacy_url' => '#',
        ]);
    }
}
