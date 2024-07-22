<?php

declare(strict_types=1);

namespace App\Exception\Security;

use DomainException;

use function sprintf;

final class CreateAccessDeniedException extends DomainException
{
    public static function deniedByUnauthorizedRoleFromRole(string $role): self
    {
        return new CreateAccessDeniedException(sprintf('Only user with [%s] or greater can create this type of resource.', $role));
    }

    public static function deniedByUnauthorizedRoleFromClassAndRole(string $class, string $role): self
    {
        return new CreateAccessDeniedException(sprintf('Only user with [%s] or greater can create resources of type [%s].', $role, $class));
    }
}
