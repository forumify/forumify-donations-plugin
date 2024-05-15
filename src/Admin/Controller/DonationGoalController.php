<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Controller;

use Forumify\Admin\Crud\AbstractCrudController;
use Forumify\Donations\Admin\Form\DonationGoalType;
use Forumify\Donations\Entity\DonationGoal;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('goals', 'goals')]
class DonationGoalController extends AbstractCrudController
{
    protected function getEntityClass(): string
    {
        return DonationGoal::class;
    }

    protected function getTableName(): string
    {
        return 'Forumify\\Donations\\DonationGoalTable';
    }

    protected function getForm(): FormInterface
    {
        return $this->createForm(DonationGoalType::class);
    }

    protected function getTranslationPrefix(): string
    {
        return 'donations.' . parent::getTranslationPrefix();
    }
}
