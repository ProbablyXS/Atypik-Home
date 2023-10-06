<?php

namespace App\Entity;

use App\Repository\TypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TypesRepository::class)]
class Types
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'types', targetEntity: Hostings::class)]
    private Collection $hostings;

    public function __construct()
    {
        $this->hostings = new ArrayCollection();
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
            $hosting->setTypes($this);
        }

        return $this;
    }

    public function removeHosting(Hostings $hosting): static
    {
        if ($this->hostings->removeElement($hosting)) {
            // set the owning side to null (unless already changed)
            if ($hosting->getTypes() === $this) {
                $hosting->setTypes(null);
            }
        }

        return $this;
    }
}
