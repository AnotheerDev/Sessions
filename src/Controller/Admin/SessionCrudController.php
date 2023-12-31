<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

// ici j'ai modifé le code pour que les champs s'affichent dans l'ordre et avec les infos que je veux
// Ne pas oublier d'importer les classes en haut du fichier
    public function configureFields(string $pageName): iterable
    {
        return [
            // ne pas afficher l'id car si je dois créer une session je veux que l'id soit généré automatiquement
            // IdField::new('id'),
            TextField::new('SessionName'),
            DateTimeField::new('startSession'),
            DatetimeField::new('endSession'),
            IntegerField::new('nbPlace'),
            AssociationField::new('sessionFormation'),
            AssociationField::new('formateur'),
            AssociationField::new('sessionUser'),
            // je dois avoir une liste déroulante pour les modules qui est dans l'entiry Programme
            AssociationField::new('sessionProgramme'),
        ];
    }

}
