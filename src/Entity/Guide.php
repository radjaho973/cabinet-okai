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
    private ?string $thumbnail = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $publishAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(length: 500)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'guide', targetEntity: ImagesGuide::class)]
    private Collection $imagesGuide;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $old_slugs = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    public function __construct()
    {
        $this->imagesGuide = new ArrayCollection();
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

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, ImagesGuide>
     */
    public function getImagesGuide(): Collection
    {
        return $this->imagesGuide;
    }

    public function addImagesGuide(ImagesGuide $imagesGuide): static
    {
        if (!$this->imagesGuide->contains($imagesGuide)) {
            $this->imagesGuide->add($imagesGuide);
            $imagesGuide->setGuide($this);
        }

        return $this;
    }

    public function removeImagesGuide(ImagesGuide $imagesGuide): static
    {
        if ($this->imagesGuide->removeElement($imagesGuide)) {
            // set the owning side to null (unless already changed)
            if ($imagesGuide->getGuide() === $this) {
                $imagesGuide->setGuide(null);
            }
        }

        return $this;
    }

    public function getOldSlugs(): ?array
    {
        return $this->old_slugs;
    }

    public function setOldSlugs(?array $old_slugs): static
    {
        $this->old_slugs = $old_slugs;

        return $this;
    }
    
    public function addOldSlugs(string $slug)
    {
        return $this->old_slugs[] = $slug;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
