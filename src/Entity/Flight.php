<?php

namespace App\Entity;

use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
class Flight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(length: 255)]
    private ?string $origen = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\OneToOne(inversedBy: 'flights', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Captain $fligths = null;

    #[ORM\ManyToMany(targetEntity: Passenger::class, inversedBy: 'passengers')]
    private Collection $passengers;

    #[ORM\OneToMany(mappedBy: 'turns', targetEntity: Steward::class)]
    private Collection $Stewards;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
        $this->Stewards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getOrigen(): ?string
    {
        return $this->origen;
    }

    public function setOrigen(string $origen): static
    {
        $this->origen = $origen;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getFligths(): ?Captain
    {
        return $this->fligths;
    }

    public function setFligths(Captain $fligths): static
    {
        $this->fligths = $fligths;

        return $this;
    }

    /**
     * @return Collection<int, Passenger>
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(Passenger $passenger): static
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers->add($passenger);
        }

        return $this;
    }

    public function removePassenger(Passenger $passenger): static
    {
        $this->passengers->removeElement($passenger);

        return $this;
    }

    /**
     * @return Collection<int, Steward>
     */
    public function getStewards(): Collection
    {
        return $this->Stewards;
    }

    public function addSteward(Steward $steward): static
    {
        if (!$this->Stewards->contains($steward)) {
            $this->Stewards->add($steward);
            $steward->setTurns($this);
        }

        return $this;
    }

    public function removeSteward(Steward $steward): static
    {
        if ($this->Stewards->removeElement($steward)) {
            // set the owning side to null (unless already changed)
            if ($steward->getTurns() === $this) {
                $steward->setTurns(null);
            }
        }

        return $this;
    }
}
