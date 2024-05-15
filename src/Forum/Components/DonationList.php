<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Components;

use Doctrine\ORM\QueryBuilder;
use Forumify\Core\Component\List\AbstractDoctrineList;
use Forumify\Donations\Repository\DonationRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('Forumify\Donations\DonationList', '@ForumifyDonationsPlugin/forum/components/donation_list.html.twig')]
class DonationList extends AbstractDoctrineList
{
    #[LiveProp]
    public ?int $goalId = null;

    public function __construct(
        private readonly DonationRepository $donationRepository,
    ) {
    }

    protected function getQueryBuilder(): QueryBuilder
    {
        $qb = $this->donationRepository->createQueryBuilder('d')
            ->orderBy('d.createdAt', 'DESC');

        if ($this->goalId !== null) {
            $qb->where('d.goal = :goal')->setParameter('goal', $this->goalId);
        }

        return $qb;
    }

    protected function getCount(): int
    {
        return $this->donationRepository->count($this->goalId === null
            ? []
            : ['goal' => $this->goalId]);
    }
}
