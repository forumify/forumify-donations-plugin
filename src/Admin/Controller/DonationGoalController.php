<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Controller;

use Forumify\Admin\Crud\AbstractCrudController;
use Forumify\Donations\Admin\Form\DonationGoalType;
use Forumify\Donations\Entity\DonationGoal;
use Forumify\Plugin\Attribute\PluginVersion;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('goals', 'goals')]
#[PluginVersion('forumify/forumify-donations-plugin', 'regular')]
class DonationGoalController extends AbstractCrudController
{
    protected ?string $permissionView = 'donations.admin.donation_goals.view';
    protected ?string $permissionCreate = 'donations.admin.donation_goals.manage';
    protected ?string $permissionEdit = 'donations.admin.donation_goals.manage';
    protected ?string $permissionDelete = 'donations.admin.donation_goals.manage';

    protected function getEntityClass(): string
    {
        return DonationGoal::class;
    }

    protected function getTableName(): string
    {
        return 'Forumify\\Donations\\DonationGoalTable';
    }

    protected function getForm(?object $data): FormInterface
    {
        return $this->createForm(DonationGoalType::class, $data);
    }

    protected function getTranslationPrefix(): string
    {
        return 'donations.' . parent::getTranslationPrefix();
    }
}
