<?php

declare(strict_types=1);

namespace Forumify\Donations\Entity;

use Doctrine\ORM\Mapping as ORM;
use Forumify\Core\Entity\BlameableEntityTrait;
use Forumify\Core\Entity\IdentifiableEntityTrait;
use Forumify\Core\Entity\TimestampableEntityTrait;
use Forumify\Core\Entity\User;
use Forumify\Donations\Repository\DonationRepository;

#[ORM\Table('donation_donation')]
#[ORM\Entity(repositoryClass: DonationRepository::class)]
class Donation
{
    use IdentifiableEntityTrait;
    use TimestampableEntityTrait;
    use BlameableEntityTrait;

    #[ORM\Column(unique: true, nullable: true)]
    private ?string $transactionId = null;

    #[ORM\Column(type: 'integer')]
    private int $amount;

    #[ORM\ManyToOne(User::class)]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?User $user = null;

    #[ORM\ManyToOne(DonationGoal::class, inversedBy: 'donations')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?DonationGoal $goal = null;

    #[ORM\Column(type: 'json')]
    private mixed $payload = [];

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(?string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    public function getAmount(): float
    {
        return $this->amount / 100;
    }

    public function getAmountRaw(): int
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = (int)round($amount * 100);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getGoal(): ?DonationGoal
    {
        return $this->goal;
    }

    public function setGoal(?DonationGoal $goal): void
    {
        $this->goal = $goal;
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }

    public function setPayload(mixed $payload): void
    {
        $this->payload = $payload;
    }
}
