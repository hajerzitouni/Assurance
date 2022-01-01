<?php

namespace App\Entity;

use App\Repository\ValidatedHolidayByRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValidatedHolidayByRepository::class)
 */
class ValidatedHolidayBy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="validatedHolidayBy")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=HolidayRequest::class, inversedBy="validatedHolidayBies")
     */
    private $holiday_id;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
            $userId->setValidatedHolidayBy($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->user_id->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getValidatedHolidayBy() === $this) {
                $userId->setValidatedHolidayBy(null);
            }
        }

        return $this;
    }

    public function getHolidayId(): ?HolidayRequest
    {
        return $this->holiday_id;
    }

    public function setHolidayId(?HolidayRequest $holiday_id): self
    {
        $this->holiday_id = $holiday_id;

        return $this;
    }
}
