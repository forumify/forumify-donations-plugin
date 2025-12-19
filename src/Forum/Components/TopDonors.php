<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Components;

use Forumify\Core\Entity\User;
use Forumify\Core\Repository\UserRepository;
use Forumify\Donations\Repository\DonationRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Forumify\Donations\TopDonors', '@ForumifyDonationsPlugin/forum/components/top_donors.html.twig')]
class TopDonors
{
    public function __construct(
        private readonly DonationRepository $donationRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @return array<array{user: User, userId: int, donationTotal: int, donationCount: int}>
     */
    public function getTopDonors(): array
    {
        $topDonors = $this->donationRepository->getTopDonorQuery(3)->getQuery()->getResult();
        foreach ($topDonors as &$donor) {
            $donor['user'] = $this->userRepository->find($donor['userId']);
        }

        return $topDonors;
    }
}
