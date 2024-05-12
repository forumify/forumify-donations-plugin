<?php

declare(strict_types=1);

namespace Forumify\Donations\Forum\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('', 'donations')]
class DonationsController extends AbstractController
{
    #[Route('', 'dashboard')]
    public function __invoke(): Response
    {
        return new Response('ok');
    }
}
