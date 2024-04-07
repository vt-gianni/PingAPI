<?php

namespace App\Entity;

use App\Repository\SerieUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SerieUserRepository::class)]
class SerieUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'serieUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Serie $serie = null;

    #[ORM\ManyToOne(inversedBy: 'serieUsers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["tournaments_read", "series_read"])]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups(["tournaments_read", "series_read"])]
    private ?bool $hasPaid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isHasPaid(): ?bool
    {
        return $this->hasPaid;
    }

    public function setHasPaid(bool $hasPaid): static
    {
        $this->hasPaid = $hasPaid;

        return $this;
    }
}
