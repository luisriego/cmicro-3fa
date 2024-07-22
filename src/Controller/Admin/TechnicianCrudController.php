<?php

namespace App\Controller\Admin;

use App\Entity\Technician;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnicianCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Technician::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Technician')
            ->setEntityLabelInPlural('Technicians')

            // in addition to a string, the argument of the singular and plural label methods
            // can be a closure that defines two nullable arguments: entityInstance (which will
            // be null in 'index' and 'new' pages) and the current page name
            ->setEntityLabelInSingular(
                fn (?Technician $Technician, ?string $pageName) => $Technician ? $Technician->toString() : 'Técnico'
            )
            ->setEntityLabelInPlural(function (?Technician $Technician, ?string $pageName) {
                return 'edit' === $pageName ? $Technician->getFullName() : 'Técnicos';
            })

            // the Symfony Security permission needed to manage the entity
            // (none by default, so you can manage all instances of the entity)
//            ->setEntityPermission('ROLE_ITT')
            ->setPageTitle('index', 'Listagem de %entity_label_plural%')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex()
                ->hideWhenCreating()
                ->setFormTypeOption('disabled', 'edit' === $pageName),
            TextField::new('slug', 'Nome sem espaços e nem caracteres especiais')
                ->hideOnIndex()
                ->hideWhenCreating()
                ->setFormTypeOption('disabled', 'edit' === $pageName),
            TextField::new('name', 'Nome')->hideOnIndex(),
            TextField::new('surname', 'Sobrenome')->hideOnIndex(),
            TextField::new('fullName', 'Nome Completo')
                ->hideOnForm(),
            DateTimeField::new('createdOn', 'Criado em')
                ->setFormTypeOption('disabled', 'edit' === $pageName),
            DateTimeField::new('updatedOn', 'Atualizado em')
                ->setFormTypeOption('disabled', 'edit' === $pageName),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, \EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        // if user defined sort is not set
        if (0 === count($searchDto->getSort())) {
            $queryBuilder
                ->addSelect('CONCAT(entity.name, \' \', entity.surname) AS HIDDEN fullName')
                ->addOrderBy('fullName', 'DESC');
        }

        return $queryBuilder;
    }
}
