<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Entity;

use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\BookingDTOInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bookings
 *
 * @ORM\Table(
 *     name="bookings", uniqueConstraints={@ORM\UniqueConstraint(name="reference_UNIQUE", columns={"reference"})}
 * )
 * @ORM\Entity(repositoryClass="App\Infrastructure\Data\Repository\BookingsRepository")
 */
class Bookings implements BookingDTOInterface
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="reference", type="string", length=6, nullable=false, options={"fixed"=true})
     *
     * @var string
     */
    private $reference;

    /**
     * @ORM\Column(name="check_in", type="date", nullable=false)
     *
     * @var DateTime
     */
    private $checkIn;

    /**
     * @ORM\Column(name="check_out", type="date", nullable=false)
     *
     * @var DateTime
     */
    private $checkOut;

    /**
     * @ORM\Column(name="people", type="int", nullable=false)
     *
     * @var int
     */
    private $people;

    /**
     * @ORM\Column(name="status", type="int", nullable=false)
     *
     * @var int
     */
    private $status;

    /**
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     *
     * @var DateTime|null
     */
    private $modifiedAt;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     *
     * @var DateTime|null
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Infrastructure\Data\Entity\Insurances", mappedBy="booking")
     *
     * @var Insurances|null
     */
    private $insurance;

    /**
     * Get id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set reference.
     *
     * @param string $reference
     * @return Bookings
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference.
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Set checkIn.
     *
     * @param DateTime $checkIn
     * @return Bookings
     */
    public function setCheckIn($checkIn)
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    /**
     * Get checkIn.
     */
    public function getCheckIn(): DateTime
    {
        return $this->checkIn;
    }

    /**
     * Set checkOut.
     *
     * @param DateTime $checkOut
     * @return Bookings
     */
    public function setCheckOut($checkOut)
    {
        $this->checkOut = $checkOut;

        return $this;
    }

    /**
     * Get checkOut.
     */
    public function getCheckOut(): DateTime
    {
        return $this->checkOut;
    }

    /**
     * Set people.
     *
     * @param int $people
     * @return Bookings
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people.
     */
    public function getPeople(): int
    {
        return $this->people;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return Bookings
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set modifiedAt.
     *
     * @param DateTime|null $modifiedAt
     * @return Bookings
     */
    public function setModifiedAt($modifiedAt = null)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt.
     *
     * @return DateTime|null
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set createdAt.
     *
     * @param DateTime|null $createdAt
     * @return Bookings
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function isInsured(): bool
    {
        return $this->status === BookingStatusEnum::Insured->value;
    }

    public function isCancelled(): bool
    {
        return $this->status === BookingStatusEnum::Cancelled->value;
    }

    public function getInsurance(): ?Insurances
    {
        return $this->insurance;
    }

    public function setInsurance(?Insurances $insurance): self
    {
        $this->insurance = $insurance;
        return $this;
    }

    public function getPremiumAmount(): float
    {
        return $this->insurance?->getPremiumAmount() ?? 0;
    }
}
