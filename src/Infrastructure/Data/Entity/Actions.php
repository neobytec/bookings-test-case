<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Entity;

use App\Infrastructure\Data\Entity\Bookings;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Actions
 *
 * @ORM\Table(name="actions", indexes={@ORM\Index(name="fk_actions_1_idx", columns={"booking_id"})})
 * @ORM\Entity(repositoryClass="App\Infrastructure\Data\Repository\ActionsRepository")
 */
class Actions
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true}, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="action", type="integer", nullable=false, unique=false)
     *
     * @var int
     */
    private $action;

    /**
     * @ORM\Column(name="check_in", type="date", nullable=false, unique=false)
     *
     * @var DateTime
     */
    private $checkIn;

    /**
     * @ORM\Column(name="check_out", type="date", nullable=false, unique=false)
     *
     * @var DateTime
     */
    private $checkOut;

    /**
     * @ORM\Column(name="people", type="integer", nullable=false, unique=false)
     *
     * @var int
     */
    private $people;

    /**
     * @ORM\Column(
     *     name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"}, unique=false
     * )
     *
     * @var DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Data\Entity\Bookings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="booking_id", referencedColumnName="id", nullable=true)
     * })
     *
     * @var Bookings|null
     */
    private $booking;

    /**
     * Get id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set action.
     *
     * @param int $action
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
     * @return int
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
     * @param int $people
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
     * @return int
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
