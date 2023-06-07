<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Entity;

use App\Infrastructure\Data\Entity\Bookings;
use DateTime;

/**
 * Insurances
 */
class Insurances
{
    private ?int $id = null;

    /** @var string */
    private $policy;

    /** @var DateTime */
    private $createdAt;

    /** @var Bookings|null */
    private $booking;

    /**
     * Get id.
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * Set policy.
     *
     * @param string $policy
     * @return Insurances
     */
    public function setPolicy($policy)
    {
        $this->policy = $policy;

        return $this;
    }

    /**
     * Get policy.
     *
     * @return string
     */
    public function getPolicy()
    {
        return $this->policy;
    }

    /**
     * Set createdAt.
     *
     * @param DateTime $createdAt
     * @return Insurances
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set booking.
     *
     * @return Insurances
     */
    public function setBooking(?Bookings $booking = null)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking.
     *
     * @return Bookings|null
     */
    public function getBooking()
    {
        return $this->booking;
    }
}
