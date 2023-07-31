<?php

namespace App\Controller\Admin;

use App\Entity\UserSecu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserSecuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserSecu::class;
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
