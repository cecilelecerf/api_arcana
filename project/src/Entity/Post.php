<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:post']],
    denormalizationContext: ['groups' => ['write:post']]
)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:post', 'write:post'
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'read:post'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups([
        'read:post'
    ])]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 2,
        max: 150,
        minMessage: 'Votre titre doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre titre ne peut pas dépasser {{ limit }} caractères'
    )]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z0-9][a-zA-Z0-9\s\-_]{0,148}[a-zA-Z0-9]$/",
        message:"Le titre est invalide"
    )]
    #[Groups([
        'read:post', 'write:post'
    ])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 3,
        minMessage: 'Votre description doit comporter au moins {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z0-9\s\-,.?!:;'\"\"()]+$/",
        message:"La description est invalide"
    )]
    #[Groups([
        'read:post', 'write:post'
    ])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'read:post', 'write:post'
    ])]
    private ?PicturePost $picture_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'read:post', 'write:post'
    ])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'read:post', 'write:post'
    ])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[Groups([
        'read:post', 'write:post'
    ])]
    private ?User $user_id = null;

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

    public function getPictureId(): ?PicturePost
    {
        return $this->picture_id;
    }

    public function setPictureId(?PicturePost $picture_id): self
    {
        $this->picture_id = $picture_id;

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

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
