<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Components;

use Doctrine\ORM\QueryBuilder;
use Forumify\Core\Component\List\AbstractDoctrineList;
use Forumify\Donations\Repository\DonationGoalRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('Forumify\Donations\DonationGoalHistoryList', '@ForumifyDonationsPlugin/forum/components/donation_goal_list.html.twig')]
class DonationGoalHistoryList extends AbstractDoctrineList
{
    public function __construct(private readonly DonationGoalRepository $donationGoalRepository)
    {
    }

    protected function getQueryBuilder(): QueryBuilder
    {
        return $this->donationGoalRepository
            ->createQueryBuilder('dg')
            ->where('dg.to < :now')
            ->setParameter('now', (new \DateTime())->setTime(0, 0))
            ->addOrderBy('dg.to', 'DESC');
    }

    protected function getCount(): int
    {
        return $this->donationGoalRepository
            ->createQueryBuilder('dg')
            ->select('COUNT(dg.id)')
            ->where('dg.to < :now')
            ->setParameter('now', (new \DateTime())->setTime(0, 0))
            ->getQuery()
            ->getSingleScalarResult();
    }
}
