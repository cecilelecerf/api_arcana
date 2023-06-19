<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ApiResource]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:classe'
    ])]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:classe'
    ])]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'types')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classe $classe = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: TypeCategoryClasse::class, orphanRemoval: true)]
    #[Groups([
        'read:classe'
    ])]
    private Collection $typeCategoryClasses;

    public function __construct()
    {
        $this->typeCategoryClasses = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->modifiedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeImmutable $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection<int, TypeCategoryClasse>
     */
    public function getTypeCategoryClasses(): Collection
    {
        return $this->typeCategoryClasses;
    }

    public function addTypeCategoryClass(TypeCategoryClasse $typeCategoryClass): self
    {
        if (!$this->typeCategoryClasses->contains($typeCategoryClass)) {
            $this->typeCategoryClasses->add($typeCategoryClass);
            $typeCategoryClass->setType($this);
        }

        return $this;
    }

    public function removeTypeCategoryClass(TypeCategoryClasse $typeCategoryClass): self
    {
        if ($this->typeCategoryClasses->removeElement($typeCategoryClass)) {
            // set the owning side to null (unless already changed)
            if ($typeCategoryClass->getType() === $this) {
                $typeCategoryClass->setType(null);
            }
        }

        return $this;
    }
}
