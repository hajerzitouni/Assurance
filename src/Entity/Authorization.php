<?php

namespace App\Entity;

use App\Repository\AuthorizationRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=AuthorizationRepository::class)
 */
class Authorization
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="authorizations")
     */
    private $validate_by;

    /**
     * @ORM\Column(type="float")
     */
    private $hours;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function __construct()
    {
        $this->created_at=new \DateTimeImmutable("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $statut): self
    {
        $this->status = $statut;

        return $this;
    }

    public function getValidateBy(): ?User
    {
        return $this->validate_by;
    }

    public function setValidateBy(?User $validate_by): self
    {
        $this->validate_by = $validate_by;

        return $this;
    }

    public function getHours(): ?float
    {
        return $this->hours;
    }

    public function setHours(float $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTimeImmutable("now");
    }
}
