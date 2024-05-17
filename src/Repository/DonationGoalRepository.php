<?php

declare(strict_types=1);

namespace Forumify\Donations\Repository;

use DateTime;
use Forumify\Core\Repository\AbstractRepository;
use Forumify\Donations\Entity\DonationGoal;

class DonationGoalRepository extends AbstractRepository
{
    public static function getEntityClass(): string
    {
        return DonationGoal::class;
    }

    /**
     * @return array<DonationGoal>
     */
    public function findActiveGoals(): array
    {
        return $this->createQueryBuilder('dg')
            ->orderBy('dg.to', 'DESC')
            ->where('dg.from IS NULL or dg.from <= :now')
            ->andWhere('dg.to IS NULL or dg.to >= :now')
            ->setParameter('now', (new DateTime())->setTime(0, 0))
            ->addOrderBy('dg.from', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
