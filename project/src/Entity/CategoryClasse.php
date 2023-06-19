<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryClasseRepository::class)]
#[ApiResource]
class CategoryClasse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
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

    #[ORM\Column]
    #[Groups([
        'read:classe'
    ])]
    private ?bool $resident = null;

    #[ORM\OneToMany(mappedBy: 'categoryClasse', targetEntity: TypeCategoryClasse::class, orphanRemoval: true)]
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

    public function isResident(): ?bool
    {
        return $this->resident;
    }

    public function setResident(bool $resident): self
    {
        $this->resident = $resident;

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
            $typeCategoryClass->setCategoryClasse($this);
        }

        return $this;
    }

    public function removeTypeCategoryClass(TypeCategoryClasse $typeCategoryClass): self
    {
        if ($this->typeCategoryClasses->removeElement($typeCategoryClass)) {
            // set the owning side to null (unless already changed)
            if ($typeCategoryClass->getCategoryClasse() === $this) {
                $typeCategoryClass->setCategoryClasse(null);
            }
        }

        return $this;
    }
}
