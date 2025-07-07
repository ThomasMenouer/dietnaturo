<?php


namespace App\Presentation\Web\Form\Admin;

use App\Domain\Shop\Entity\ProductsCover;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductsCoverAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_uri' => false,
            'label' => 'Image',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductsCover::class,
        ]);
    }
}
