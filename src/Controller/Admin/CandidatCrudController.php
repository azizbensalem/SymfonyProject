<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Regles;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CandidatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {   
        $regles =  $this->getDoctrine()->getManager()->getRepository(Regles::class)->findAll();
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('Photo')
            ->setBasePath('/uploads/Photo')
            ->onlyOnIndex(),
            // TextareaField::new('Photo')
            // ->setFormType(VichImageType::class)
            // ->hideOnIndex(),
            EmailField::new('email')->hideOnIndex(),
            TextField::new('nomUtilisateur'),
            IntegerField::new('telephone'),
            TextField::new('type'),
            TextField::new('regles')->hideOnForm(),
            AssociationField::new('regles')->onlyOnForms()->setFormTypeOptions(["choices" => $regles]),
        ];
    }
    

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $role = "ROLE_CANDIDAT";
        $qb = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->andWhere('entity.roles LIKE :role');
        $qb->setParameter('role', '%"'.'ROLE_CANDIDAT'.'"%');

        return $qb;
    }
}
