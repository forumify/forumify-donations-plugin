<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Controller;

use Forumify\Admin\Crud\AbstractCrudController;
use Forumify\Donations\Admin\Form\DonationType;
use Forumify\Donations\Entity\Donation;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('', 'donations')]
class DonationController extends AbstractCrudController
{
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
