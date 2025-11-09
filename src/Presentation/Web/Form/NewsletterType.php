<?php

namespace App\Presentation\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email :',
                'attr' => [
                    'placeholder' => 'exemple@domaine.com',
                    'class' => 'form-control rounded-pill',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S’inscrire',
                'row_attr' => ['class' => 'text-center'],
                'attr' => ['class' => 'btn btn-custom-color rounded-pill text-white px-4'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
