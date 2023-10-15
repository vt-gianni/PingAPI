<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
#[UniqueEntity("number", message: "Un club a déjà été créé avec ce numéro identifiant.")]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/',
            security: 'is_granted("ROLE_USER") === true'
        )
    ],
    routePrefix: '/clubs',
    normalizationContext: ["groups" => ["clubs_read"]]
)]
class Club
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["clubs_read", "users_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $addressMore = null;

    #[ORM\Column(length: 255)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $number = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $gym = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $mailAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["clubs_read", "users_read"])]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'club', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

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

    public function getAddressMore(): ?string
    {
        return $this->addressMore;
    }

    public function setAddressMore(?string $addressMore): static
    {
        $this->addressMore = $addressMore;

        return $this;
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

    public function getGym(): ?string
    {
        return $this->gym;
    }

    public function setGym(?string $gym): static
    {
        $this->gym = $gym;

        return $this;
    }

    public function getMailAddress(): ?string
    {
        return $this->mailAddress;
    }

    public function setMailAddress(?string $mailAddress): static
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setClub($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getClub() === $this) {
                $user->setClub(null);
            }
        }

        return $this;
    }
}
