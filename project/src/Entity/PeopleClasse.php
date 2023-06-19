<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PeopleClasseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PeopleClasseRepository::class)]
#[ApiResource]
class PeopleClasse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:people'
    ])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'peopleClasses')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:classe',
        'read:people', 'write:people'
    ])]
    private ?People $people = null;

    #[ORM\ManyToOne(inversedBy: 'peopleClasses')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message:"Veuillez bien remplir tous les champs")]
    #[Groups([
        'read:people', 'write:people'
    ])]
    private ?Classe $classe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeople(): ?People
    {
        return $this->people;
    }

    public function setPeople(?People $people): self
    {
        $this->people = $people;

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
}
