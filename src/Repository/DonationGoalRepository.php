<?php

declare(strict_types=1);

namespace Forumify\Donations\Repository;

use Forumify\Core\Repository\AbstractRepository;
use Forumify\Donations\Entity\DonationGoal;

class DonationGoalRepository extends AbstractRepository
{
    public static function getEntityClass(): string
    {
        return DonationGoal::class;
    }
}
