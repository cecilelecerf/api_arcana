<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
#[ApiResource]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:people'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Votre nom doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern:"/^[A-Za-zÀ-ÿ\-' ]+$/",
        message:"Le nom de famille est invalide"
    )]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?bool $member = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Email(message: "L'adresse email {{ value }} n'est pas valide.")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Votre adresse mail doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre adresse mail ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern:"/^[A-Za-z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
        message:"L'adresse e-mail est invalide"
    )]
    #[Groups([
        'read:people', 'write:people',
        'read:classe'
    ])]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?bool $resident = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?bool $paid = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Positive(
        message: 'La valeur du nombre de chèque n\'est pas bonne'
    )]
    #[Assert\Type(
        type: 'integer',
        message: "La valeur {{ value }} n'est pas un {{ type }} valide.",
        )]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?int $meansOfPayment = null;

    #[ORM\OneToMany(mappedBy: 'family', targetEntity: People::class, orphanRemoval: true)]
    private Collection $people;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    public function __construct()
    {
        $this->people = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->modifiedAt = new \DateTimeImmutable();
        $this->member = false;
        $this->resident = false;
        $this->paid = false;
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

    public function isMember(): ?bool
    {
        return $this->member;
    }

    public function setMember(bool $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function isPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getMeansOfPayment(): ?int
    {
        return $this->meansOfPayment;
    }

    public function setMeansOfPayment(int $meansOfPayment): self
    {
        $this->meansOfPayment = $meansOfPayment;

        return $this;
    }

    /**
     * @return Collection<int, People>
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(People $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people->add($person);
            $person->setFamily($this);
        }

        return $this;
    }

    public function removePerson(People $person): self
    {
        if ($this->people->removeElement($person)) {
            // set the owning side to null (unless already changed)
            if ($person->getFamily() === $this) {
                $person->setFamily(null);
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
