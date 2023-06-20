<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PicturePostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PicturePostRepository::class)]
#[ApiResource]
class PicturePost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:post', 'write:post'
    ])]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Le chemin d\accès doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Le chemin d\accès ne peut pas dépasser {{ limit }} caractères'
    )]
    #[Groups([
        'read:post', 'write:post',        
        'read:event', 'write:event'
    ])]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Votre alt doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Votre alt ne peut pas dépasser {{ limit }} caractères'
    )]
    #[Assert\Regex(
        pattern:"/^[\p{L}\p{N}\s\-_.,!?'\"\/]*$/u",
        message:"L'alt est invalide"
    )]
    #[Groups([
        'read:post', 'write:post',
        'read:event', 'write:event'
    ])]
    private ?string $alt = null;

    #[ORM\OneToMany(mappedBy: 'picture_id', targetEntity: Post::class)]
    private ?Collection $posts;

    #[ORM\OneToMany(mappedBy: 'picture_id', targetEntity: Event::class)]
    private ?Collection $events;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->modifiedAt = new \DateTimeImmutable();
        $this->events = new ArrayCollection();
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }
    
    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setPictureId($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getPictureId() === $this) {
                $post->setPictureId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setPictureId($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getPictureId() === $this) {
                $event->setPictureId(null);
            }
        }

        return $this;
    }
}
