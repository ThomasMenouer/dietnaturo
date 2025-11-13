<?php


namespace App\Presentation\Web\Form\Admin;

use App\Domain\Pages\Entity\Accompagnement\AccompagnementContent;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AccompagnementContentAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu',
                'config' => [
                    'toolbar' => 'standard',
                    'uiColor' => '#ffffff',
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => 'Image (upload)',
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Ordre d’affichage',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccompagnementContent::class,
        ]);
    }
}
