<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Entity;

use App\Infrastructure\Data\Entity\Bookings;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Insurances
 *
 * @ORM\Table(
 *     name="insurances",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="policy_UNIQUE", columns={"policy"})},
 *     indexes={@ORM\Index(name="fk_insurances_1_idx", columns={"booking_id"})}
 * )
 * @ORM\Entity(repositoryClass="App\Infrastructure\Data\Repository\InsurancesRepository")
 */
class Insurances
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="policy", type="string", length=9, nullable=false, options={"fixed"=true})
     *
     * @var string
     */
    private $policy;

    /**
     * @ORM\Column(name="premium_amount", type="float", length=4, nullable=false, options={"fixed"=true})
     *
     * @var float
     */
    private $premiumAmount;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     *
     * @var DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Data\Entity\Bookings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="booking_id", referencedColumnName="id")
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

    public function getPremiumAmount(): float
    {
        return $this->premiumAmount;
    }

    public function setPremiumAmount(float $premiumAmount): self
    {
        $this->premiumAmount = $premiumAmount;
        return $this;
    }
}
