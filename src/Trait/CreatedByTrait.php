<?php

declare(strict_types=1);

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\SecurityBundle\Security;

trait CreatedByTrait
{
    #[ORM\Column(type: 'string', length: 50)]
    protected string $createdBy;

    public function __construct(
        private readonly Security $security,
    ) {}

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function creator(string $creator): void
    {
        $this->createdBy = $creator;
    }
}
