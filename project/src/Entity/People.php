<?php

namespace App\Entity;

use App\Repository\PeopleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PeopleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:people']],
    denormalizationContext: ['groups' => ['write:people']]
)]


class People
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:people', 'write:people',
        'read:classe'
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?\DateTimeImmutable $modifiedAt = null;        

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Votre prénom doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre prénom ne peut pas dépasser {{ limit }} caractères'
    )]
    #[Assert\Regex(
        pattern:"/^[A-Za-zÀ-ÿ\-' ]+$/",
        message:"Le prénom est invalide"
    )]
    #[Groups([
        'read:people', 'write:people',
        'read:classe'
    ])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Votre nom doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères'
    )]
    #[Assert\Regex(
        pattern:"/^[A-Za-zÀ-ÿ\-' ]+$/",
        message:"Le nom de famille est invalide"
    )]
    #[Groups([
        'read:people', 'write:people',
        'read:classe'
    ])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Votre adresse doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre adresse ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: "/^[\d]+ [a-zA-ZÀ-ÿ0-9\s'\-]+$/",
        message:"Votre adresse est invalide"
    )]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?string $street = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 4,
        max: 255,
        minMessage: 'Votre ville doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre ville ne peut pas dépasser {{ limit }}',
    )]
    #[Assert\Regex(
        pattern:"/^[A-Za-zÀ-ÿ\s'\-]+$/",
        message:"La ville est invalide"
    )]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?string $city = null;

    #[ORM\Column(length: 6)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 5,
        max: 5,
        minMessage: 'Le code postal doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Le code postal ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern:"/^[0-9]{5}$/",
        message:"Le code postal est invalide"
    )]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?string $postalCode = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 2,
        max: 180,
        minMessage: 'Votre numéro de téléphone doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre numéro de téléphone ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern:"/^(\+33|0)[1-9](?:[\s.-]*\d{2}){4}$/",
        message:"Le numéro est invalide"
    )]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?string $phone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Type("\DateTimeImmutable")]
    #[Groups([
        'read:people', 'write:people',
        'read:classe'
    ])]
    private ?\DateTimeImmutable $dateOfBirth = null;

    #[ORM\ManyToOne(inversedBy: 'people')]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:people', 'write:people',
        'read:classe'
    ])]
    private ?Family $family = null;

    #[ORM\OneToMany(mappedBy: 'people', targetEntity: PeopleInstrument::class, orphanRemoval: true)]
    #[Groups([
        'read:people', 'write:people',
        'read:classe'
    ])]
    private Collection $peopleInstruments;

    #[ORM\OneToMany(mappedBy: 'people', targetEntity: PeopleClasse::class, orphanRemoval: true)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'reads:people', 'write:people',
    ])]
    private Collection $peopleClasses;

    public function __construct()
    {
        $this->peopleInstruments = new ArrayCollection();
        $this->peopleClasses = new ArrayCollection();
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeImmutable $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

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
            $peopleInstrument->setPeople($this);
        }

        return $this;
    }

    public function removePeopleInstrument(PeopleInstrument $peopleInstrument): self
    {
        if ($this->peopleInstruments->removeElement($peopleInstrument)) {
            // set the owning side to null (unless already changed)
            if ($peopleInstrument->getPeople() === $this) {
                $peopleInstrument->setPeople(null);
            }
        }

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
            $peopleClass->setPeople($this);
        }

        return $this;
    }

    public function removePeopleClass(PeopleClasse $peopleClass): self
    {
        if ($this->peopleClasses->removeElement($peopleClass)) {
            // set the owning side to null (unless already changed)
            if ($peopleClass->getPeople() === $this) {
                $peopleClass->setPeople(null);
            }
        }

        return $this;
    }
}
