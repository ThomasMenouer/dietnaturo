<?php

namespace App\Presentation\Web\Form\Admin;

use Symfony\Component\Form\AbstractType;
use App\Domain\Shop\Entity\ProductsEbook;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsEbookAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', VichFileType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            'label' => 'Fichier ebook',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductsEbook::class,
        ]);
    }
}
