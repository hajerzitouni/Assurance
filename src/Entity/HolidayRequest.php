<?php

namespace App\Entity;

use App\Repository\HolidayRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HolidayRequestRepository::class)
 */
class HolidayRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today",message="le jour de début doit être supérieur à aujourd'hui")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\Expression(
     *     "this.getStartDate() < this.getEndDate()",
     *      message="La date fin ne doit pas être antérieure à la date début")
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="holidayRequests")
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="test")
     */
    private $validby;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getNbjours()
    {
        return $this->nbjours;
    }

    /**
     * @param mixed $nbjours
     */
    public function setNbjours($nbjours): void
    {
        $this->nbjours = $nbjours;
    }
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbjours;


    public function __construct()
    {
        $this->created_at=new \DateTimeImmutable("now");
        $this->updated_at=new \DateTimeImmutable("now");
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $create_at): self
    {
        $this->created_at = $create_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

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

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTimeImmutable("now");
    }

    public function getValidby(): ?User
    {
        return $this->validby;
    }

    public function setValidby(?User $validby): self
    {
        $this->validby = $validby;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }



}
