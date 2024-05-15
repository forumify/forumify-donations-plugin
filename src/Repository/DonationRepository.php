<?php

declare(strict_types=1);

namespace Forumify\Donations\Repository;

use Forumify\Core\Repository\AbstractRepository;
use Forumify\Donations\Entity\Donation;

class DonationRepository extends AbstractRepository
{
    public static function getEntityClass(): string
    {
        return Donation::class;
    }

    public function getTopDonors(int $limit = null): array
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

        return $query
            ->getQuery()
            ->getResult();
    }
}
