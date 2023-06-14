<?php

namespace App\Entity;

use App\Repository\PassengerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PassengerRepository::class)]
class Passenger extends Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $seat = null;

    #[ORM\ManyToMany(targetEntity: Flight::class, mappedBy: 'passengers')]
    private Collection $passengers;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeat(): ?int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): static
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * @return Collection<int, Flight>
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(Flight $passenger): static
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers->add($passenger);
            $passenger->addPassenger($this);
        }

        return $this;
    }

    public function removePassenger(Flight $passenger): static
    {
        if ($this->passengers->removeElement($passenger)) {
            $passenger->removePassenger($this);
        }

        return $this;
    }
}
