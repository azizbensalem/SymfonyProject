<?php

namespace App\Controller\Admin;

use App\Entity\Regles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReglesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Regles::class;
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
