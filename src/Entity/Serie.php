<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'series')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $beginDateTime = null;

    #[ORM\Column]
    private ?bool $isHandicap = null;

    #[ORM\Column]
    private ?bool $isOpen = null;

    #[ORM\Column(nullable: true)]
    private ?int $minAge = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxAge = null;

    #[ORM\Column(nullable: true)]
    private ?int $minPoints = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxPoints = null;

    #[ORM\Column]
    private ?bool $onlyMen = null;

    #[ORM\Column]
    private ?bool $onlyWomen = null;

    #[ORM\Column]
    private ?int $minPlaces = null;

    #[ORM\Column]
    private ?int $maxPlaces = null;

    #[ORM\Column]
    private ?int $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): static
    {
        $this->tournament = $tournament;

        return $this;
    }

    public function getBeginDateTime(): ?\DateTimeInterface
    {
        return $this->beginDateTime;
    }

    public function setBeginDateTime(\DateTimeInterface $beginDateTime): static
    {
        $this->beginDateTime = $beginDateTime;

        return $this;
    }

    public function isIsHandicap(): ?bool
    {
        return $this->isHandicap;
    }

    public function setIsHandicap(bool $isHandicap): static
    {
        $this->isHandicap = $isHandicap;

        return $this;
    }

    public function isIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(bool $isOpen): static
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    public function setMinAge(?int $minAge): static
    {
        $this->minAge = $minAge;

        return $this;
    }

    public function getMaxAge(): ?int
    {
        return $this->maxAge;
    }

    public function setMaxAge(?int $maxAge): static
    {
        $this->maxAge = $maxAge;

        return $this;
    }

    public function getMinPoints(): ?int
    {
        return $this->minPoints;
    }

    public function setMinPoints(?int $minPoints): static
    {
        $this->minPoints = $minPoints;

        return $this;
    }

    public function getMaxPoints(): ?int
    {
        return $this->maxPoints;
    }

    public function setMaxPoints(?int $maxPoints): static
    {
        $this->maxPoints = $maxPoints;

        return $this;
    }

    public function isOnlyMen(): ?bool
    {
        return $this->onlyMen;
    }

    public function setOnlyMen(bool $onlyMen): static
    {
        $this->onlyMen = $onlyMen;

        return $this;
    }

    public function isOnlyWomen(): ?bool
    {
        return $this->onlyWomen;
    }

    public function setOnlyWomen(bool $onlyWomen): static
    {
        $this->onlyWomen = $onlyWomen;

        return $this;
    }

    public function getMinPlaces(): ?int
    {
        return $this->minPlaces;
    }

    public function setMinPlaces(int $minPlaces): static
    {
        $this->minPlaces = $minPlaces;

        return $this;
    }

    public function getMaxPlaces(): ?int
    {
        return $this->maxPlaces;
    }

    public function setMaxPlaces(int $maxPlaces): static
    {
        $this->maxPlaces = $maxPlaces;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }
}
