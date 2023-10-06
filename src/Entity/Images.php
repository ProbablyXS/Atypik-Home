<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: true)]
    private ?hostings $hostings = null;

    #[ORM\OneToOne(mappedBy: 'images', cascade: ['persist', 'remove'])]
    private ?Users $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHostings(): ?hostings
    {
        return $this->hostings;
    }

    public function setHostings(?hostings $hostings): static
    {
        $this->hostings = $hostings;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(Users $users): static
    {
        // set the owning side of the relation if necessary
        if ($users->getImages() !== $this) {
            $users->setImages($this);
        }

        $this->users = $users;

        return $this;
    }
}
