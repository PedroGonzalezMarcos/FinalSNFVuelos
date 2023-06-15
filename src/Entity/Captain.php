<?php

namespace App\Entity;

use App\Repository\CaptainRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaptainRepository::class)]
class Captain extends Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $captain_license_id = null;

    #[ORM\OneToOne(mappedBy: 'captain', cascade: ['persist', 'remove'])]
    private ?Flight $flight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaptainLicenseId(): ?int
    {
        return $this->captain_license_id;
    }

    public function setCaptainLicenseId(int $captain_license_id): static
    {
        $this->captain_license_id = $captain_license_id;

        return $this;
    }

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(Flight $flight): static
    {
        // set the owning side of the relation if necessary
        if ($flight->getCaptain() !== $this) {
            $flight->setCaptain($this);
        }

        $this->flight = $flight;

        return $this;
    }
}
