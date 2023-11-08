<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use App\State\UserProcessor;
use App\Validator\ValidateRole;
use App\Validator\ValidateSexe;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity("email", message: "Un utilisateur existe déjà avec cette adresse mail.")]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
            security: 'is_granted("ROLE_USER") === true'
        ),
        new GetCollection(
            uriTemplate: '/',
            security: 'is_granted("ROLE_USER") === true'
        ),
        new Post(
            uriTemplate: '',
            processor: UserProcessor::class
        ),
        new Put(
            uriTemplate: '/{id}',
            requirements: ['id' => '\d+'],
            denormalizationContext: ['groups' => ['users_put']],
            security: 'is_granted("ROLE_USER") === true'
        )
    ],
    routePrefix: '/users',
    normalizationContext: ["groups" => ["users_read"]],
    denormalizationContext: ["groups" => ["users_write"]]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["users_read"])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Le champ 'email' est obligatoire.")]
    #[Assert\Email(
        message: "L'adresse email '{{ value }}' n'est pas valide."
    )]
    #[Groups(["users_read", "users_write"])]
    private ?string $email = null;

    #[ORM\Column]
    #[ValidateRole]
    #[Groups(["users_read"])]
    private array $roles = ["ROLE_USER"];

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(
        min: 8,
        max: 200,
        minMessage: "Le mot de passe doit comporter au moins 8 caractères.",
        maxMessage: "Le mot de passe ne peut excéder 200 caractères."
    )]
    #[Groups(["users_write"])]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le prénom doit comporter au moins 2 caractères.",
        maxMessage: "Le prénom ne doit pas comporter plus de 50 caractères."
    )]
    #[Assert\Regex("/^[A-Za-zÀ-úœ'\-\s]+$/", message: "Le champ 'lastName' contient des caractères invalides.")]
    #[Groups(["users_read", "users_write"])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit comporter au moins 2 caractères.",
        maxMessage: "Le nom ne doit pas comporter plus de 50 caractères."
    )]
    #[Assert\Regex("/^[A-Za-zÀ-úœ'\-\s]+$/", message: "Le champ 'lastName' contient des caractères invalides.")]
    #[Groups(["users_read", "users_write"])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["users_read", "users_write"])]
    private ?string $avatar = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["users_read", "users_write"])]
    private ?string $licenceNumber = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(500)]
    #[Groups(["users_read", "users_write"])]
    private ?int $officialPoints = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(["users_read", "users_write"])]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'users')]
    #[Groups(["users_read", "users_write"])]
    private ?Club $club = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["users_read", "users_write"])]
    #[ValidateSexe]
    private ?string $sexe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getLicenceNumber(): ?string
    {
        return $this->licenceNumber;
    }

    public function setLicenceNumber(?string $licenceNumber): static
    {
        $this->licenceNumber = $licenceNumber;

        return $this;
    }

    public function getOfficialPoints(): ?int
    {
        return $this->officialPoints;
    }

    public function setOfficialPoints(?int $officialPoints): static
    {
        $this->officialPoints = $officialPoints;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): static
    {
        $this->club = $club;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }
}
