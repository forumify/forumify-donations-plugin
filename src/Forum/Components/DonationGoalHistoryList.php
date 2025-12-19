<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Components;

use Doctrine\ORM\QueryBuilder;
use Forumify\Core\Component\List\AbstractDoctrineList;
use Forumify\Donations\Entity\DonationGoal;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

/**
 * @extends AbstractDoctrineList<DonationGoal>
 */
#[AsLiveComponent('Forumify\Donations\DonationGoalHistoryList', '@ForumifyDonationsPlugin/forum/components/donation_goal_list.html.twig')]
class DonationGoalHistoryList extends AbstractDoctrineList
{
    protected function getEntityClass(): string
    {
        return DonationGoal::class;
    }

    protected function getQuery(): QueryBuilder
    {
        return $this->repository
            ->createQueryBuilder('dg')
            ->where('dg.to < :now')
            ->setParameter('now', (new \DateTime())->setTime(0, 0))
            ->addOrderBy('dg.to', 'DESC');
    }
}
