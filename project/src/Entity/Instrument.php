<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\InstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InstrumentRepository::class)]
#[ApiResource]
class Instrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:classe'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:people',
        'read:classe'
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $icon = null;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: PeopleInstrument::class, orphanRemoval: true)]
    private Collection $peopleInstruments;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    public function __construct()
    {
        $this->peopleInstruments = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->modifiedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection<int, PeopleInstrument>
     */
    public function getPeopleInstruments(): Collection
    {
        return $this->peopleInstruments;
    }

    public function addPeopleInstrument(PeopleInstrument $peopleInstrument): self
    {
        if (!$this->peopleInstruments->contains($peopleInstrument)) {
            $this->peopleInstruments->add($peopleInstrument);
            $peopleInstrument->setInstrument($this);
        }

        return $this;
    }

    public function removePeopleInstrument(PeopleInstrument $peopleInstrument): self
    {
        if ($this->peopleInstruments->removeElement($peopleInstrument)) {
            // set the owning side to null (unless already changed)
            if ($peopleInstrument->getInstrument() === $this) {
                $peopleInstrument->setInstrument(null);
            }
        }

        return $this;
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
}
