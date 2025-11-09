<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Accompagnement;


use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use App\Domain\Pages\Entity\Accompagnement\Accompagnement;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use App\Domain\Pages\Entity\Accompagnement\AccompagnementContent;
use App\Presentation\Web\Form\Admin\AccompagnementContentAdminType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AccompagnementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accompagnement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            SlugField::new('slug')->setTargetFieldName('title'),

            CollectionField::new('contents', 'Blocs de contenu')
                ->setEntryType(AccompagnementContentAdminType::class)
                ->allowAdd()
                ->allowDelete()
                ->setSortable(true),
        ];
    }
}
