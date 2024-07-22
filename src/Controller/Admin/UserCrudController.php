<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')

            // in addition to a string, the argument of the singular and plural label methods
            // can be a closure that defines two nullable arguments: entityInstance (which will
            // be null in 'index' and 'new' pages) and the current page name
            ->setEntityLabelInSingular(
                fn (?User $user, ?string $pageName) => $user ? $user->toString() : 'Usuário'
            )
            ->setEntityLabelInPlural(function (?User $user, ?string $pageName) {
                return 'edit' === $pageName ? $user->getUserIdentifier() : 'Usuários';
            })

            // the Symfony Security permission needed to manage the entity
            // (none by default, so you can manage all instances of the entity)
//            ->setEntityPermission('ROLE_ADMIN')
            ->setPageTitle('index', 'Listagem de %entity_label_plural%')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $rolesOptions = [
            'Usuário' => 'ROLE_USER',
            'Técnico' => 'ROLE_ITT',
            'Administrador' => 'ROLE_ADMIN',
            'Dono da porra toda' => 'ROLE_SUPER_ADMIN',
        ];

        return [
            IdField::new('id')
                ->hideOnIndex()
                ->setFormTypeOption('disabled', 'edit' === $pageName),
            TextField::new('username', 'Username'),
            EmailField::new('email', 'Email')
                ->setFormTypeOption('disabled', 'edit' === $pageName), // Desabilita a edição do email apenas na página de edição,
            BooleanField::new('isActive', 'Está ativo?'),
            BooleanField::new('isVerified', 'Está verificado?')
                ->setFormTypeOption('disabled', 'edit' === $pageName),
            DateTimeField::new('createdOn', 'Criado em')
                ->hideOnIndex()
                ->setFormTypeOption('disabled', 'edit' === $pageName),
            DateTimeField::new('updatedOn', 'Atualizado em')
                ->hideOnIndex()
                ->setFormTypeOption('disabled', 'edit' === $pageName),
//            ArrayField::new('roles', 'Roles'),
            ChoiceField::new('roles', 'Roles')
                ->setFormType(ChoiceType::class)
                ->setFormTypeOptions([
                    'choices' => $rolesOptions,
                    'multiple' => false,
                    'expanded' => false, // Set to true for checkboxes, false for a dropdown
                ])
                ->setPermission('ROLE_ADMIN'),
        ];
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['hashPassword'],
        ];
    }

//    public function hashPassword(BeforeEntityPersistedEvent $event)
//    {
//        $entity = $event->getEntityInstance();
//        if (!($entity instanceof User)) {
//            return;
//        }
//
//        $hashedPassword = $this->passwordHasher->hashPassword($entity, $entity->getPassword());
//        $entity->setPassword($hashedPassword);
//    }

    private function getHighestRole(array $roles): string {
        $roleHierarchy = [
            'ROLE_SUPER_ADMIN' => 1,
            'ROLE_ADMIN' => 2,
            'ROLE_ITT' => 3,
            'ROLE_USER' => 4,
        ];

        $highestRole = 'ROLE_SUPER_ADMIN'; // Valor padrão
        $highestRank = 0;

        foreach ($roles as $role) {
            if (isset($roleHierarchy[$role]) && $roleHierarchy[$role] > $highestRank) {
                $highestRole = $role;
                $highestRank = $roleHierarchy[$role];
            }
        }

        return $highestRole;
    }

    public function hashPassword(BeforeEntityPersistedEvent $event) {
        $entity = $event->getEntityInstance();
        if (!($entity instanceof User)) {
            return;
        }

        // Determinar o maior role
        $highestRole = $this->getHighestRole($entity->getRoles());
        $entity->setRoles([$highestRole]); // Armazenar apenas o maior role

        $hashedPassword = $this->passwordHasher->hashPassword($entity, $entity->getPassword());
        $entity->setPassword($hashedPassword);
    }

//// Ajustar o campo roles na função configureFields
//    public function configureFields(string $pageName): iterable {
//        $rolesOptions = [
//            'Usuário' => 'ROLE_USER',
//            'Técnico' => 'ROLE_ITT',
//            'Administrador' => 'ROLE_ADMIN',
//            'Dono da porra toda' => 'ROLE_SUPER_ADMIN',
//        ];
//
//        return [
//            // Outros campos...
//            ChoiceField::new('roles', 'Roles')
//                ->setFormType(ChoiceType::class)
//                ->setFormTypeOptions([
//                    'choices' => $rolesOptions,
//                    'multiple' => false, // Não permitir múltiplas seleções
//                    'expanded' => false, // Dropdown
//                ])
//                ->setPermission('ROLE_ADMIN'),
//            // Outros campos...
//        ];
//    }
}
