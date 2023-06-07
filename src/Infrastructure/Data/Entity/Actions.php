<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Entity;

use App\Infrastructure\Data\Entity\Bookings;
use DateTime;

/**
 * Actions
 */
class Actions
{
    private ?int $id = null;

    /** @var bool */
    private $action;

    /** @var DateTime */
    private $checkIn;

    /** @var DateTime */
    private $checkOut;

    /** @var bool */
    private $people;

    /** @var DateTime */
    private $createdAt;

    /** @var Bookings|null */
    private $booking;

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
     * Set action.
     *
     * @param bool $action
     * @return Actions
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action.
     *
     * @return bool
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set checkIn.
     *
     * @param DateTime $checkIn
     * @return Actions
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
     * @return Actions
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
     * @return Actions
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
     * Set createdAt.
     *
     * @param DateTime $createdAt
     * @return Actions
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
     * @return Actions
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
