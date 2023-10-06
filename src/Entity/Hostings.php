<?php

namespace App\Entity;

use App\Repository\HostingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types as ImuTime;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HostingsRepository::class)]
#[UniqueEntity(fields: ['name'], message: "Il existe déjà un logement avec ce titre")]
class Hostings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'hostings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    #[ORM\OneToMany(mappedBy: 'hostings', targetEntity: Images::class, orphanRemoval: true, cascade:["persist"])]
    private Collection $images;

    #[ORM\Column]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $eco_score = null;

    #[ORM\Column]
    private ?int $night_price = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $zipcode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $number_of_sleeps = null;

    #[ORM\Column]
    private ?bool $wifi = null;

    #[ORM\Column]
    private ?float $surface = null;

    #[ORM\Column]
    private ?int $number_of_peoples = null;

    #[ORM\Column]
    private ?string $suggested_activities = null;

    #[ORM\Column]
    private ?int $number_of_bedrooms = null;

    #[ORM\Column]
    private ?bool $pets_allowed = null;

    #[ORM\Column]
    private ?bool $parking = null;

    #[ORM\Column]
    private ?bool $electricity = null;

    #[ORM\Column]
    private ?int $number_of_bathrooms = null;

    #[ORM\ManyToOne(inversedBy: 'hostings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Types $types = null;

    #[ORM\Column(type: ImuTime::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $departure_time = null;

    #[ORM\Column(type: ImuTime::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $arrival_time = null;

    #[ORM\ManyToOne(inversedBy: 'hostings')]
    private ?Country $country = null;

    #[ORM\Column]
    private ?bool $smoking_allowed = null;

    #[ORM\OneToMany(mappedBy: 'hostings', targetEntity: Unavailability::class, cascade:["persist"])]
    private Collection $unavailabilities;

    #[ORM\OneToMany(mappedBy: 'hostings', targetEntity: Reservation::class, cascade:["persist"])]
    private Collection $reservations;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->unavailabilities = new ArrayCollection();
        $this->reservations = new ArrayCollection();
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

    public function getUsers(): ?users
    {
        return $this->users;
    }

    public function setUsers(?users $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setHostings($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getHostings() === $this) {
                $image->setHostings(null);
            }
        }

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

    public function getEcoScore(): ?int
    {
        return $this->eco_score;
    }

    public function setEcoScore(int $eco_score): static
    {
        $this->eco_score = $eco_score;

        return $this;
    }

    public function getNightPrice(): ?float
    {
        return $this->night_price;
    }

    public function setNightPrice(float $night_price): static
    {
        $this->night_price = $night_price;

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

    public function getNumberOfSleeps(): ?int
    {
        return $this->number_of_sleeps;
    }

    public function setNumberOfSleeps(int $number_of_sleeps): static
    {
        $this->number_of_sleeps = $number_of_sleeps;

        return $this;
    }

    public function getWifi(): ?int
    {
        return $this->wifi;
    }

    public function setWifi(int $wifi): static
    {
        $this->wifi = $wifi;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getNumberOfPeoples(): ?int
    {
        return $this->number_of_peoples;
    }

    public function setNumberOfPeoples(int $number_of_peoples): static
    {
        $this->number_of_peoples = $number_of_peoples;

        return $this;
    }

    public function getSuggestedActivities(): ?string
    {
        return $this->suggested_activities;
    }

    public function setSuggestedActivities(string $suggested_activities): static
    {
        $this->suggested_activities = $suggested_activities;

        return $this;
    }

    public function getNumberOfBedrooms(): ?int
    {
        return $this->number_of_bedrooms;
    }

    public function setNumberOfBedrooms(int $number_of_bedrooms): static
    {
        $this->number_of_bedrooms = $number_of_bedrooms;

        return $this;
    }

    public function isPetsAllowed(): ?bool
    {
        return $this->pets_allowed;
    }

    public function setPetsAllowed(bool $pets_allowed): static
    {
        $this->pets_allowed = $pets_allowed;

        return $this;
    }

    public function isParking(): ?bool
    {
        return $this->parking;
    }

    public function setParking(bool $parking): static
    {
        $this->parking = $parking;

        return $this;
    }

    public function isElectricity(): ?bool
    {
        return $this->electricity;
    }

    public function setElectricity(bool $electricity): static
    {
        $this->electricity = $electricity;

        return $this;
    }

    public function getNumberOfBathrooms(): ?int
    {
        return $this->number_of_bathrooms;
    }

    public function setNumberOfBathrooms(int $number_of_bathrooms): static
    {
        $this->number_of_bathrooms = $number_of_bathrooms;

        return $this;
    }

    public function getTypes(): ?Types
    {
        return $this->types;
    }

    public function setTypes(?Types $types): static
    {
        $this->types = $types;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeImmutable
    {
        return $this->departure_time;
    }

    public function setDepartureTime(\DateTimeImmutable $departure_time): static
    {
        $this->departure_time = $departure_time;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeImmutable
    {
        return $this->arrival_time;
    }

    public function setArrivalTime(\DateTimeImmutable $arrival_time): static
    {
        $this->arrival_time = $arrival_time;

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

    public function isSmokingAllowed(): ?bool
    {
        return $this->smoking_allowed;
    }

    public function setSmokingAllowed(bool $smoking_allowed): static
    {
        $this->smoking_allowed = $smoking_allowed;

        return $this;
    }

    /**
     * @return Collection<int, Unavailability>
     */
    public function getUnavailabilities(): Collection
    {
        return $this->unavailabilities;
    }

    public function addUnavailability(Unavailability $unavailability): static
    {
        if (!$this->unavailabilities->contains($unavailability)) {
            $this->unavailabilities->add($unavailability);
            $unavailability->setHostings($this);
        }

        return $this;
    }

    public function removeUnavailability(Unavailability $unavailability): static
    {
        if ($this->unavailabilities->removeElement($unavailability)) {
            // set the owning side to null (unless already changed)
            if ($unavailability->getHostings() === $this) {
                $unavailability->setHostings(null);
            }
        }

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
            $reservation->setHostings($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHostings() === $this) {
                $reservation->setHostings(null);
            }
        }

        return $this;
    }
}
