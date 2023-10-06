<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UsersRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['username'], message: "Il existe déjà un compte avec ce nom d'utilisateur")]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 20)]
    private ?string $firstname = null;

    #[ORM\Column(length: 20)]
    private ?string $lastname = null;

    #[ORM\Column(nullable: true)]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    private ?int $zipcode = null;

    #[ORM\Column(nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $last_connection = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_of_birth = null;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Genders $genders = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(options:["default" => 1])]
    private ?Status $Status = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Hostings::class, orphanRemoval: true)]
    private Collection $hostings;

    #[ORM\OneToOne(inversedBy: 'users', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Images $images = null;

    #[ORM\Column(nullable: true, length: 1000)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Country $country = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;


    public function __construct()
    {
        $this->last_connection = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $this->created_at = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
        $this->hostings = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getLastConnection(): ?\DateTimeImmutable
    {
        return $this->last_connection;
    }

    public function setLastConnection(?\DateTimeImmutable $last_connection): static
    {
        $this->last_connection = $last_connection;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(?\DateTimeImmutable $date_of_birth): static
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getGenders(): ?Genders
    {
        return $this->genders;
    }

    public function setGenders(?Genders $genders): static
    {
        $this->genders = $genders;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->Status;
    }

    public function setStatus(?Status $Status): static
    {
        $this->Status = $Status;

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
            $hosting->setUsers($this);
        }

        return $this;
    }

    public function removeHosting(Hostings $hosting): static
    {
        if ($this->hostings->removeElement($hosting)) {
            // set the owning side to null (unless already changed)
            if ($hosting->getUsers() === $this) {
                $hosting->setUsers(null);
            }
        }

        return $this;
    }

    public function getImages(): ?Images
    {
        return $this->images;
    }

    public function setImages(Images $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setUsers($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUsers() === $this) {
                $reservation->setUsers(null);
            }
        }

        return $this;
    }
}
