<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Components;

use DateTime;
use Doctrine\ORM\QueryBuilder;
use Forumify\Core\Component\List\AbstractDoctrineList;
use Forumify\Donations\Repository\DonationGoalRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('Forumify\Donations\DonationGoalList', '@ForumifyDonationsPlugin/forum/components/donation_goal_list.html.twig')]
class DonationGoalList extends AbstractDoctrineList
{
    public function __construct(private readonly DonationGoalRepository $donationGoalRepository)
    {
    }

    protected function getQueryBuilder(): QueryBuilder
    {
        return $this->donationGoalRepository
            ->createQueryBuilder('dg')
            ->orderBy('dg.to', 'DESC')
            ->where('dg.from IS NULL or dg.from <= :now')
            ->andWhere('dg.to IS NULL or dg.to >= :now')
            ->setParameter('now', (new DateTime())->setTime(0, 0))
            ->addOrderBy('dg.from', 'DESC');
    }

    protected function getCount(): int
    {
        return $this->donationGoalRepository->count([]);
    }
}
