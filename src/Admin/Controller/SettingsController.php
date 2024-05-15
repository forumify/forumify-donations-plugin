<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Controller;

use Forumify\Core\Repository\SettingRepository;
use Forumify\Donations\Admin\Form\SettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SettingsController extends AbstractController
{
    #[Route('settings', 'settings')]
    public function __invoke(Request $request, SettingRepository $settingRepository): Response
    {
        $formData = $settingRepository->toFormData('donations');
        $form = $this->createForm(SettingsType::class, $formData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $settingRepository->handleFormData($form->getData());
            $this->addFlash('success', 'donations.admin.settings.saved');
            return $this->redirectToRoute('donations_admin_settings');
        }

        return $this->render('@ForumifyDonationsPlugin/admin/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
