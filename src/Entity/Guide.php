<?php

namespace App\Entity;

use App\Repository\GuideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuideRepository::class)]
class Guide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $readingTime = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $publishAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\OneToMany(mappedBy: 'guide', targetEntity: SubPart::class, orphanRemoval: true)]
    private Collection $subParts;

    public function __construct()
    {
        $this->subParts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReadingTime(): ?int
    {
        return $this->readingTime;
    }

    public function setReadingTime(int $readingTime): static
    {
        $this->readingTime = $readingTime;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPublishAt(): ?\DateTimeImmutable
    {
        return $this->publishAt;
    }

    public function setPublishAt(\DateTimeImmutable $publishAt): static
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * @return Collection<int, SubPart>
     */
    public function getSubParts(): Collection
    {
        return $this->subParts;
    }

    public function addSubPart(SubPart $subPart): static
    {
        if (!$this->subParts->contains($subPart)) {
            $this->subParts->add($subPart);
            $subPart->setGuide($this);
        }

        return $this;
    }

    public function removeSubPart(SubPart $subPart): static
    {
        if ($this->subParts->removeElement($subPart)) {
            // set the owning side to null (unless already changed)
            if ($subPart->getGuide() === $this) {
                $subPart->setGuide(null);
            }
        }

        return $this;
    }
}
