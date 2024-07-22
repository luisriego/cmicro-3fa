<?php

declare(strict_types=1);

namespace App\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait CreatedOnTrait
{
    #[ORM\Column(type: 'datetime_immutable')]
    protected DateTimeImmutable $createdOn;

    public function getCreatedOn(): DateTimeImmutable
    {
        return $this->createdOn;
    }
}
