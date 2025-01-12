<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Controller;

use Forumify\Donations\Entity\Donation;
use Forumify\Donations\Entity\DonationGoal;
use Forumify\Donations\Repository\DonationRepository;
use Forumify\Plugin\Attribute\PluginVersion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[PluginVersion('forumify/forumify-donations-plugin', 'regular')]
class DonationsController extends AbstractController
{
    #[Route('', 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('@ForumifyDonationsPlugin/forum/dashboard.html.twig');
    }

    #[Route('/goal/{slug}', 'goal')]
    public function goal(DonationGoal $goal): Response
    {
        return $this->render('@ForumifyDonationsPlugin/forum/donation_goal.html.twig', [
            'goal' => $goal,
        ]);
    }

    #[Route('/goal/{slug}/donate', 'donate', methods: ['POST'])]
    public function donate(Request $request, DonationGoal $goal, DonationRepository $donationRepository): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $data['source'] = 'PayPal donate button';

        $donation = new Donation();
        $donation->setTransactionId($data['tx']);
        $donation->setAmount((float)$data['amt']);
        $donation->setUser($this->getUser());
        $donation->setGoal($goal);
        $donation->setPayload($data);

        $donationRepository->save($donation);
        return new JsonResponse(['success' => true]);
    }
}
