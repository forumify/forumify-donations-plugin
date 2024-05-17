<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Components;

use Forumify\Donations\Entity\DonationGoal;
use Forumify\Donations\Repository\DonationGoalRepository;
use Forumify\Donations\Repository\DonationRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Forumify\Donations\PreferredGoal', '@ForumifyDonationsPlugin/forum/components/preferred_goal.html.twig')]
class PreferredGoal
{
    public function __construct(
        private readonly DonationGoalRepository $donationGoalRepository,
        private readonly DonationRepository $donationRepository
    ) {
    }

    public function getPreferredGoal(): ?DonationGoal
    {
        return $this->donationGoalRepository->findOneBy(['slug' => 'upgrade-server-hardware']);

        $activeGoals = $this->donationGoalRepository->findActiveGoals();

        $lowestProgressGoal = null;
        $lowestProgress = PHP_INT_MAX;
        foreach ($activeGoals as $goal) {
            $amount = $this->donationRepository->getDonationAmount($goal);

            $progress = $amount / $goal->getGoal();
            if ($progress < $lowestProgress) {
                $lowestProgressGoal = $goal;
                $lowestProgress = $progress;
            }
        }

        return $lowestProgressGoal;
    }
}
