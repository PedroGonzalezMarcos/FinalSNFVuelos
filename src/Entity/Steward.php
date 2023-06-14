<?php

namespace App\Entity;

use App\Repository\StewardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StewardRepository::class)]
class Steward extends Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $air_crew_id = null;

    #[ORM\ManyToOne(inversedBy: 'Stewards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Flight $turns = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirCrewId(): ?int
    {
        return $this->air_crew_id;
    }

    public function setAirCrewId(int $air_crew_id): static
    {
        $this->air_crew_id = $air_crew_id;

        return $this;
    }

    public function getTurns(): ?Flight
    {
        return $this->turns;
    }

    public function setTurns(?Flight $turns): static
    {
        $this->turns = $turns;

        return $this;
    }
}
