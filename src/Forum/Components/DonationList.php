<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Components;

use Doctrine\ORM\QueryBuilder;
use Forumify\Core\Component\List\AbstractDoctrineList;
use Forumify\Donations\Entity\Donation;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

/**
 * @extends AbstractDoctrineList<Donation>
 */
#[AsLiveComponent('Forumify\Donations\DonationList', '@ForumifyDonationsPlugin/forum/components/donation_list.html.twig')]
class DonationList extends AbstractDoctrineList
{
    #[LiveProp]
    public ?int $goalId = null;

    protected function getEntityClass(): string
    {
        return Donation::class;
    }

    protected function getQuery(): QueryBuilder
    {
        $qb = $this->repository->createQueryBuilder('d')
            ->orderBy('d.createdAt', 'DESC');

        if ($this->goalId !== null) {
            $qb->where('d.goal = :goal')->setParameter('goal', $this->goalId);
        }

        return $qb;
    }
}
