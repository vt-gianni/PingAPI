<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TournamentRepository;
use App\State\TournamentProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
            security: 'is_granted("ROLE_USER") === true'
        ),
        new GetCollection(
            uriTemplate: '/',
            security: 'is_granted("ROLE_USER") === true',
            provider: TournamentProvider::class
        )
    ],
    routePrefix: '/tournaments',
    normalizationContext: ["groups" => ["tournaments_read"]]
)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["tournaments_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["tournaments_read"])]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["tournaments_read"])]
    private ?string $zipCode = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["tournaments_read"])]
    private ?\DateTimeInterface $beginDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["tournaments_read"])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["tournaments_read"])]
    private ?string $gym = null;

    #[ORM\OneToMany(mappedBy: 'tournament', targetEntity: Serie::class, orphanRemoval: true)]
    private Collection $series;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["tournaments_read"])]
    private ?string $address = null;

    public function __construct()
    {
        $this->series = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(\DateTimeInterface $beginDate): static
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getGym(): ?string
    {
        return $this->gym;
    }

    public function setGym(?string $gym): static
    {
        $this->gym = $gym;

        return $this;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(Serie $series): static
    {
        if (!$this->series->contains($series)) {
            $this->series->add($series);
            $series->setTournament($this);
        }

        return $this;
    }

    public function removeSeries(Serie $series): static
    {
        if ($this->series->removeElement($series)) {
            // set the owning side to null (unless already changed)
            if ($series->getTournament() === $this) {
                $series->setTournament(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }
}
