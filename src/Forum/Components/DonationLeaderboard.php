<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Components;

use Doctrine\ORM\QueryBuilder;
use Forumify\Core\Component\List\AbstractDoctrineList;
use Forumify\Core\Entity\User;
use Forumify\Core\Repository\UserRepository;
use Forumify\Donations\Entity\Donation;
use Forumify\Donations\Repository\DonationRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

/**
 * @extends AbstractDoctrineList<Donation>
 */
#[AsLiveComponent('Forumify\Donations\DonationLeaderboard', '@ForumifyDonationsPlugin/forum/components/donation_leaderboard.html.twig')]
class DonationLeaderboard extends AbstractDoctrineList
{
    public function __construct(
        private readonly DonationRepository $donationRepository,
        private readonly UserRepository $userRepository,
    ) {
        $this->limit = 12;
    }

    protected function getEntityClass(): string
    {
        return Donation::class;
    }

    public function getUser(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    protected function getQuery(): QueryBuilder
    {
        return $this->donationRepository->getTopDonorQuery();
    }

    protected function getTotalCount(): int
    {
        /** @var string $subQuery */
        $subQuery = $this->donationRepository->getTopDonorQuery()->getQuery()->getSQL();

        return $this->donationRepository
            ->createQueryBuilder('d')
            ->getEntityManager()
            ->getConnection()
            ->executeQuery("SELECT COUNT(*) FROM ($subQuery) AS t")
            ->fetchOne();
    }
}
