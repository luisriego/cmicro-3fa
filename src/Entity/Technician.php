<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TechnicianRepository;
use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TechnicianRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Technician
{
    use IdentifierTrait;
    use TimestampableTrait;
    use IsActiveTrait;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

//    private string $fullName = "";

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->isActive = false;
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getFullName(): string
    {
        return $this->getName() . ' ' . $this->getSurname();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateSlug(): void
    {
        $slugger = new AsciiSlugger();
        $this->slug = mb_strtolower($slugger->slug($this->name . ' ' . $this->surname)->toString());
    }

    public function toString(): string
    {
        return $this->getFullName();
    }
}
