<?php

declare(strict_types=1);

namespace Forumify\Donations\Repository;

use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Forumify\Core\Repository\AbstractRepository;
use Forumify\Donations\Entity\Donation;
use Forumify\Donations\Entity\DonationGoal;

class DonationRepository extends AbstractRepository
{
    public static function getEntityClass(): string
    {
        return Donation::class;
    }

    public function getTopDonorQuery(int $limit = null): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('d')
            ->select('u.id AS userId, SUM(d.amount) AS donationTotal, COUNT(d) as donationCount')
            ->leftJoin('d.user', 'u')
            ->where('d.user IS NOT NULL')
            ->groupBy('d.user')
            ->orderBy('donationTotal', 'DESC');

        if ($limit !== null) {
            $query->setMaxResults($limit);
        }

        return $query;
    }

    public function getDonationAmount(DonationGoal $goal): float
    {
        try {
            $amount = $this->createQueryBuilder('d')
                ->select('SUM(d.amount)')
                ->where('d.goal = :goal')
                ->groupBy('d.goal')
                ->setParameter('goal', $goal->getId())
                ->getQuery()
                ->getSingleScalarResult();

            return $amount / 100;
        } catch (NoResultException) {
            return 0;
        }
    }
}
