<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Entity;

use DateTime;

/**
 * Bookings
 */
class Bookings
{
    private ?int $id = null;

    /** @var string */
    private $reference;

    /** @var DateTime */
    private $checkIn;

    /** @var DateTime */
    private $checkOut;

    /** @var bool */
    private $people;

    /** @var DateTime|null */
    private $modifiedAt;

    /** @var DateTime|null */
    private $createdAt;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int|null
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
     *
     * @return string
     */
    public function getReference()
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
     *
     * @return DateTime
     */
    public function getCheckIn()
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
     *
     * @return DateTime
     */
    public function getCheckOut()
    {
        return $this->checkOut;
    }

    /**
     * Set people.
     *
     * @param bool $people
     * @return Bookings
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people.
     *
     * @return bool
     */
    public function getPeople()
    {
        return $this->people;
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
}
