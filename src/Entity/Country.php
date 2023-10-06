<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Hostings::class)]
    private Collection $hostings;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Users::class)]
    private Collection $users;

    public function __construct()
    {
        $this->hostings = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Hostings>
     */
    public function getHostings(): Collection
    {
        return $this->hostings;
    }

    public function addHosting(Hostings $hosting): static
    {
        if (!$this->hostings->contains($hosting)) {
            $this->hostings->add($hosting);
            $hosting->setCountry($this);
        }

        return $this;
    }

    public function removeHosting(Hostings $hosting): static
    {
        if ($this->hostings->removeElement($hosting)) {
            // set the owning side to null (unless already changed)
            if ($hosting->getCountry() === $this) {
                $hosting->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCountry($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCountry() === $this) {
                $user->setCountry(null);
            }
        }

        return $this;
    }
}
