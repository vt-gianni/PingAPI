<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use App\Controller\RegisterUserToSerie;
use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
            security: 'is_granted("ROLE_USER") === true'
        ),
        new Post(
            uriTemplate: '/{id}/register',
            requirements: ['id' => '\d+'],
            controller: RegisterUserToSerie::class,
            security: 'is_granted("ROLE_USER") === true'
        )
    ],
    routePrefix: '/series',
    normalizationContext: ["groups" => ["series_read"]],
    denormalizationContext: ["groups" => ["series_write"]]
)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'series')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?\DateTimeInterface $beginDateTime = null;

    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?bool $isHandicap = null;

    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?bool $isOpen = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?int $minAge = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?int $maxAge = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?int $minPoints = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?int $maxPoints = null;

    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?bool $onlyMen = null;

    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?bool $onlyWomen = null;

    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?int $minPlaces = null;

    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?int $maxPlaces = null;

    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?int $price = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'series')]
    #[Groups(["series_read", "tournaments_read"])]
    private Collection $usersRegistered;

    #[ORM\Column]
    #[Groups(["tournaments_read", "users_read", "series_read"])]
    private ?bool $canRegister = null;

    public function __construct()
    {
        $this->usersRegistered = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, User>
     */
    public function getUsersRegistered(): Collection
    {
        return $this->usersRegistered;
    }

    public function addUsersRegistered(User $usersRegistered): static
    {
        if (!$this->usersRegistered->contains($usersRegistered)) {
            $this->usersRegistered->add($usersRegistered);
        }

        return $this;
    }

    public function removeUsersRegistered(User $usersRegistered): static
    {
        $this->usersRegistered->removeElement($usersRegistered);

        return $this;
    }

    public function isCanRegister(): ?bool
    {
        return $this->canRegister;
    }

    public function setCanRegister(bool $canRegister): static
    {
        $this->canRegister = $canRegister;

        return $this;
    }
}
