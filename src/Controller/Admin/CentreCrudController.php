<?php

namespace App\Controller\Admin;

use App\Entity\Centre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class CentreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Centre::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('province', 'Province'),
            TextField::new('nom', 'Nom du centre'),
            TextField::new('ville', 'Ville'),
            IntegerField::new('cp', 'Code Postal'),
            TextField::new('rue', 'Rue'),
            TextField::new('numero', 'Numéro'),
            UrlField::new('map', 'Lien google maps'),
            UrlField::new('site', 'Site web pour prendre rendez-vous'),
        ];
    }

}
