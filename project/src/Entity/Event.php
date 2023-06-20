<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:event']],
    denormalizationContext: ['groups' => ['write:event']]
)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:event'
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'read:event'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups([
        'read:event'
    ])]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez bien remplir tous les champs.")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Le titre doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern:"/^[A-Za-zÀ-ÿ0-9\-' ]+$/",
        message:"Le nom de famille est invalide"
    )]
    #[Groups([
        'read:event', 'write:event'
    ])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Veuillez bien remplir tous les champs.")]
    #[Assert\Length(
        min: 50,
        minMessage: 'La description doit comporter au moins {{ limit }} caractères',
    )]
    
    #[Assert\Regex(
        pattern:"/^[\w\s.,?!'-]*$/",
        message:"La description est invalide"
    )]
    #[Groups([
        'read:event', 'write:event'
    ])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez bien remplir tous les champs.")]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'La localisation doit comporter au moins {{ limit }} caractères',
        maxMessage: 'La localisation ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Groups([
        'read:event', 'write:event'
    ])]
    private ?string $localisation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "Veuillez bien remplir tous les champs.")]
    #[Groups([
        'read:event', 'write:event'
    ])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "Veuillez bien remplir tous les champs.")]
    #[Groups([
        'read:event', 'write:event'
    ])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'read:event', 'write:event'
    ])]
    private ?PicturePost $picture_id = null;

    public function __construct()
    {
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPictureId(): ?PicturePost
    {
        return $this->picture_id;
    }

    public function setPictureId(?PicturePost $picture_id): self
    {
        $this->picture_id = $picture_id;

        return $this;
    }
}
