<?php

declare(strict_types=1);

namespace Forumify\Donations\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Forumify\Core\Entity\BlameableEntityTrait;
use Forumify\Core\Entity\IdentifiableEntityTrait;
use Forumify\Core\Entity\SluggableEntityTrait;
use Forumify\Core\Entity\TimestampableEntityTrait;
use Forumify\Donations\Repository\DonationGoalRepository;

#[ORM\Table('donation_goal')]
#[ORM\Entity(repositoryClass: DonationGoalRepository::class)]
class DonationGoal
{
    public const STATE_BEFORE_START = 'before-start';
    public const STATE_AFTER_END = 'after-end';
    public const STATE_GOAL_REACHED = 'goal-reached';
    public const STATE_OPEN = 'open';

    use IdentifiableEntityTrait;
    use SluggableEntityTrait;
    use TimestampableEntityTrait;
    use BlameableEntityTrait;

    #[ORM\Column]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'integer')]
    private int $goal;

    #[ORM\Column(type: 'boolean')]
    private bool $closeWhenReached = false;

    #[ORM\Column(nullable: true)]
    private ?string $paypalButtonId = null;

    #[ORM\Column(name: '`from`', type: 'date', nullable: true)]
    private ?DateTime $from = null;

    #[ORM\Column(name: '`to`', type: 'date', nullable: true)]
    private ?DateTime $to = null;

    /** @var Collection<int, Donation> */
    #[ORM\OneToMany(mappedBy: 'goal', targetEntity: Donation::class)]
    private Collection $donations;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getGoal(): float
    {
        return $this->goal / 100;
    }

    public function setGoal(float $goal): void
    {
        $this->goal = (int)round($goal * 100);
    }

    public function isCloseWhenReached(): bool
    {
        return $this->closeWhenReached;
    }

    public function setCloseWhenReached(bool $closeWhenReached): void
    {
        $this->closeWhenReached = $closeWhenReached;
    }

    public function getPaypalButtonId(): ?string
    {
        return $this->paypalButtonId;
    }

    public function setPaypalButtonId(?string $paypalButtonId): void
    {
        $this->paypalButtonId = $paypalButtonId;
    }

    public function getFrom(): ?DateTime
    {
        return $this->from;
    }

    public function setFrom(?DateTime $from): void
    {
        $this->from = $from;
    }

    public function getTo(): ?DateTime
    {
        return $this->to;
    }

    public function setTo(?DateTime $to): void
    {
        $this->to = $to;
    }

    /**
     * @return Collection<int, Donation>
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    /**
     * @param Collection<int, Donation>|array<Donation> $donations
     */
    public function setDonations(Collection|array $donations): void
    {
        $this->donations = !$donations instanceof Collection
            ? new ArrayCollection($donations)
            : $donations;
    }

    public function getAmount(): float
    {
        $amountRaw = $this->getDonations()
            ->map(fn (Donation $donation) => $donation->getAmountRaw())
            ->reduce(fn (int $a, int $b) => $a + $b, 0);

        return $amountRaw / 100;
    }

    public function getState(): string
    {
        $now = new DateTime();

        $start = $this->from;
        if ($start !== null && $now < $start) {
            return self::STATE_BEFORE_START;
        }

        $end = $this->to?->setTime(23, 59, 59);
        if ($end !== null && $now > $end) {
            return self::STATE_AFTER_END;
        }

        $goalReached = $this->getAmount() >= $this->getGoal();
        if ($goalReached && $this->closeWhenReached) {
            return self::STATE_GOAL_REACHED;
        }

        return self::STATE_OPEN;
    }
}
