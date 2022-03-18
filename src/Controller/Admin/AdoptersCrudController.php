<?php

namespace App\Controller\Admin;

use App\Entity\Adopters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdoptersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adopters::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Adoptants')
            ->setEntityLabelInSingular('Adoptant')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username'),
            TextField::new('plainPassword')->hideOnIndex(),
            TextField::new('firstName'),
            TextField::new('surname'),
            EmailField::new('mail'),
            TextField::new('phone'),
            TextField::new('city'),
            TextField::new('department'),
            IntegerField::new('child'),
            BooleanField::new('gotAnimals'),
            DateField::new('creation_date')->hideOnForm(),
        ];
    }
}
