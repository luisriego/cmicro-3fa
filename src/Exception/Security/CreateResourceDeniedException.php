<?php

declare(strict_types=1);

namespace App\Exception\Security;

use DomainException;

use function sprintf;

final class CreateResourceDeniedException extends DomainException
{
    public static function deniedByNotBeTheOwner(): self
    {
        return new CreateResourceDeniedException('Only the Owner can create this type of resource.');
    }

    public static function deniedByUnauthorizedRoleFromClassAndRole(string $class, string $role): self
    {
        return new CreateResourceDeniedException(sprintf('Only user with [%s] or greater can create resources of type [%s].', $role, $class));
    }
}
