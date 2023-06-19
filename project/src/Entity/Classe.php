<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:classe']],
    denormalizationContext: ['groups' => ['write:classe']]
)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:people',
        'read:classe'
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'read:classe'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups([
        'read:classe'
    ])]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:people',
        'read:classe'
    ])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:classe'
    ])]
    private ?string $picture = null;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: PeopleClasse::class, orphanRemoval: true)]
    #[Groups([
        'read:classe'
    ])]
    private Collection $peopleClasses;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Type::class, orphanRemoval: true)]
    #[Groups([
        'read:classe'
    ])]
    private Collection $types;

    public function __construct()
    {
        $this->peopleClasses = new ArrayCollection();
        $this->types = new ArrayCollection();
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, PeopleClasse>
     */
    public function getPeopleClasses(): Collection
    {
        return $this->peopleClasses;
    }

    public function addPeopleClass(PeopleClasse $peopleClass): self
    {
        if (!$this->peopleClasses->contains($peopleClass)) {
            $this->peopleClasses->add($peopleClass);
            $peopleClass->setClasse($this);
        }

        return $this;
    }

    public function removePeopleClass(PeopleClasse $peopleClass): self
    {
        if ($this->peopleClasses->removeElement($peopleClass)) {
            // set the owning side to null (unless already changed)
            if ($peopleClass->getClasse() === $this) {
                $peopleClass->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->setClasse($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->types->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getClasse() === $this) {
                $type->setClasse(null);
            }
        }

        return $this;
    }
}
