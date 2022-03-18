<?php

namespace App\Controller\Admin;

use App\Entity\Adopters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdoptersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adopters::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
