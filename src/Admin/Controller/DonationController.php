<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Controller;

use Forumify\Admin\Crud\AbstractCrudController;
use Forumify\Donations\Admin\Form\DonationType;
use Forumify\Donations\Entity\Donation;
use Forumify\Plugin\Attribute\PluginVersion;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('', 'donations')]
#[PluginVersion('forumify/forumify-donations-plugin', 'regular')]
class DonationController extends AbstractCrudController
{
    protected ?string $permissionView = 'donations.admin.donations.view';
    protected ?string $permissionCreate = 'donations.admin.donations.manage';
    protected ?string $permissionEdit = 'donations.admin.donations.manage';
    protected ?string $permissionDelete = 'donations.admin.donations.manage';

    protected function getEntityClass(): string
    {
        return Donation::class;
    }

    protected function getTableName(): string
    {
        return 'Forumify\\Donations\\DonationTable';
    }

    protected function getForm(?object $data): FormInterface
    {
        return $this->createForm(DonationType::class, $data);
    }

    protected function getTranslationPrefix(): string
    {
        return 'donations.' . parent::getTranslationPrefix();
    }
}
