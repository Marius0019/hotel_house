<?php

namespace App\Controller\Admin;

use App\Entity\Chambre;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ChambreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chambre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextEditorField::new('description_courte', 'Description (courte)')->onlyOnForms(),
            TextEditorField::new('description_longue', 'Description (longue)')->onlyOnForms(),
            ImageField::new('photo')->setUploadDir('public/uploads/images/')->setUploadedFileNamePattern('[timestamp]-[slug]-[contenthash].[extension]')->onlyWhenCreating(),
            ImageField::new('photo')->setBasePath('uploads/images/')->hideOnForm(),
            ImageField::new('photo')->setUploadDir('public/uploads/images/')->setUploadedFileNamePattern('[timestamp]-[slug]-[contenthash].[extension]')->onlyWhenUpdating()->setFormTypeOptions([
                'required' => false,
            ]),
            MoneyField::new('prix_journalier', 'Prix')->setCurrency('EUR')->setNumDecimals(2),
            DateTimeField::new('date_enregistrement')->setFormat('dd/MM/yyyy à HH:mm:ss')->hideOnForm(),
            DateTimeField::new('date_arrivee', 'Date Arrivée')->setFormat('dd/MM/yyyy à HH:mm:ss')->hideOnForm(),
            DateTimeField::new('date_date_depart')->setFormat('dd/MM/yyyy à HH:mm:ss')->hideOnForm()

            
        ];
    }
    public function createEntity(string $entityFqcn)
    {
        $chambre =new $entityFqcn;
        $chambre->setDateEnregistrement(new \DateTime);
        return $chambre;
    }
    
}
