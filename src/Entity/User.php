<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $departement;
    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $adresse;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $soldecong;

    /**
     * @return mixed
     */
    public function getSoldecong()
    {
        return $this->soldecong;
    }

    /**
     * @param mixed $soldecong
     */
    public function setSoldecong($soldecong): void
    {
        $this->soldecong = $soldecong;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
    }


    /**
     * @return mixed
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param mixed $departement
     */
    public function setDepartement($departement): void
    {
        $this->departement = $departement;
    }

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    private $type = [];

    /**
     * @ORM\OneToMany(targetEntity=HolidayRequest::class, mappedBy="user_id")
     */
    private $holidayRequests;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LastName;

    /**
     * @ORM\ManyToOne(targetEntity=ValidatedHolidayBy::class, inversedBy="user_id")
     */
    private $validatedHolidayBy;

    /**
     * @ORM\OneToMany(targetEntity=Authorization::class, mappedBy="validate_by")
     */
    private $authorizations;

    /**
     * @ORM\OneToMany(targetEntity=HolidayRequest::class, mappedBy="validby")
     */
    private $test;

    public function __construct()
    {
        $this->holidayRequests = new ArrayCollection();
        $this->authorizations = new ArrayCollection();
        $this->test = new ArrayCollection();
        $this->soldecong=21;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
        return (string)$this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getType(): ?array
    {
        return $this->type;
    }

    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|HolidayRequest[]
     */
    public function getHolidayRequests(): Collection
    {
        return $this->holidayRequests;
    }

    public function addHolidayRequest(HolidayRequest $holidayRequest): self
    {
        if (!$this->holidayRequests->contains($holidayRequest)) {
            $this->holidayRequests[] = $holidayRequest;
            $holidayRequest->setUserId($this);
        }

        return $this;
    }

    public function removeHolidayRequest(HolidayRequest $holidayRequest): self
    {
        if ($this->holidayRequests->removeElement($holidayRequest)) {
            // set the owning side to null (unless already changed)
            if ($holidayRequest->getUserId() === $this) {
                $holidayRequest->setUserId(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getValidatedHolidayBy(): ?ValidatedHolidayBy
    {
        return $this->validatedHolidayBy;
    }

    public function setValidatedHolidayBy(?ValidatedHolidayBy $validatedHolidayBy): self
    {
        $this->validatedHolidayBy = $validatedHolidayBy;

        return $this;
    }

    /**
     * @return Collection|Authorization[]
     */
    public function getAuthorizations(): Collection
    {
        return $this->authorizations;
    }

    public function addAuthorization(Authorization $authorization): self
    {
        if (!$this->authorizations->contains($authorization)) {
            $this->authorizations[] = $authorization;
            $authorization->setValidateBy($this);
        }

        return $this;
    }

    public function removeAuthorization(Authorization $authorization): self
    {
        if ($this->authorizations->removeElement($authorization)) {
            // set the owning side to null (unless already changed)
            if ($authorization->getValidateBy() === $this) {
                $authorization->setValidateBy(null);
            }
        }

        return $this;
    }
}
