<?php

namespace App\Presentation\Web\Controller\Admin\Pages\Accompagnement;

use phpDocumentor\Reflection\Types\Integer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use App\Domain\Pages\Entity\Accompagnement\Accompagnement;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use App\Presentation\Web\Form\Admin\AccompagnementContentAdminType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class AccompagnementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accompagnement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Page d’accompagnement')
            ->setEntityLabelInPlural('Pages d’accompagnement')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des pages d’accompagnement')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer une page d’accompagnement')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une page d’accompagnement')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la page d’accompagnement')
            ->setHelp(Crud::PAGE_INDEX, 'Création et gestion des pages d’accompagnement.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre')
            ->setHelp("Titre de la page pour 'Mes accompagnements'"),

            IntegerField::new('pagePosition', 'Ordre d’affichage')
            ->setHelp("Ordre d’affichage de la page dans le menu. (1 = premier)"),

            SlugField::new('slug')->setTargetFieldName('title')
            ->setHelp("Le slug est généré automatiquement à partir du titre."),
        ];
    }
}
