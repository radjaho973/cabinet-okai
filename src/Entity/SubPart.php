<?php

namespace App\Entity;

use App\Repository\SubPartRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubPartRepository::class)]
class SubPart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $subPartName = null;

    #[ORM\ManyToOne(inversedBy: 'subParts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guide $guide = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $subPartContent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubPartName(): ?string
    {
        return $this->subPartName;
    }

    public function setSubPartName(string $subPartName): static
    {
        $this->subPartName = $subPartName;

        return $this;
    }

    public function getGuide(): ?Guide
    {
        return $this->guide;
    }

    public function setGuide(?Guide $guide): static
    {
        $this->guide = $guide;

        return $this;
    }

    public function getSubPartContent(): ?string
    {
        return $this->subPartContent;
    }

    public function setSubPartContent(string $subPartContent): static
    {
        $this->subPartContent = $subPartContent;

        return $this;
    }
}
