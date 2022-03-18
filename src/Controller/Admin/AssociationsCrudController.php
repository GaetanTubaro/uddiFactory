<?php

namespace App\Controller\Admin;

use App\Entity\Associations;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AssociationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Associations::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Associations')
            ->setEntityLabelInSingular('Association')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username')->hideOnIndex(),
            TextField::new('password')->hideOnIndex(),
            TextField::new('name'),
        ];
    }
}
