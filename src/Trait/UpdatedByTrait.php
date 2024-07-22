<?php

declare(strict_types=1);

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

trait UpdatedByTrait
{
    #[ORM\Column(type: 'string', length: 50)]
    protected string $updatedBy;

    //            public function __construct(
    //                private readonly TokenStorageInterface $tokenStorage
    //            ) {
    //            }

    public function getUpdatedOBy(): string
    {
        return $this->updatedBy;
    }

    public function whoUpdated(string $user): void
    {
        $this->updatedBy = $user;
    }
}
