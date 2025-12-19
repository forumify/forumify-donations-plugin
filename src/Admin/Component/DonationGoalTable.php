<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Component;

use Forumify\Core\Component\Table\AbstractDoctrineTable;
use Forumify\Donations\Entity\DonationGoal;
use Forumify\Donations\Service\CurrencyFormatter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('Forumify\Donations\DonationGoalTable', '@Forumify/components/table/table.html.twig')]
class DonationGoalTable extends AbstractDoctrineTable
{
    public function __construct(
        private readonly CurrencyFormatter $currencyFormatter,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
        $this->sort = ['from' => 'DESC', 'to' => 'DESC'];
    }

    protected function getEntityClass(): string
    {
        return DonationGoal::class;
    }

    protected function buildTable(): void
    {
        $this
            ->addColumn('title', [
                'field' => 'title',
            ])
            ->addColumn('goal', [
                'field' => 'goal',
                'renderer' => fn (float $amount, DonationGoal $goal) => $this->currencyFormatter->format($amount),
            ])
            ->addColumn('amount', [
                'field' => 'amount',
                'renderer' => fn (float $amount, DonationGoal $goal) => $this->currencyFormatter->format($amount),
            ])
            ->addColumn('from', [
                'field' => 'from',
                'renderer' => fn (?\DateTime $v) => $v?->format('Y-m-d') ?? '',
            ])
            ->addColumn('to', [
                'field' => 'to',
                'renderer' => fn (?\DateTime $v) => $v?->format('Y-m-d') ?? '',
            ])
            ->addColumn('actions', [
                'field' => 'id',
                'label' => '',
                'sortable' => false,
                'searchable' => false,
                'renderer' => $this->renderActions(...),
            ]);
    }

    private function renderActions(int $id): string
    {
        $editUrl = $this->urlGenerator->generate('donations_admin_goals_edit', ['identifier' => $id]);
        $deleteUrl = $this->urlGenerator->generate('donations_admin_goals_delete', ['identifier' => $id]);

        return "
            <a class='btn-link btn-icon btn-small' href='$editUrl'><i class='ph ph-pencil-simple-line'></i></a>
            <a class='btn-link btn-icon btn-small' href='$deleteUrl'><i class='ph ph-x'></i></a>
        ";
    }
}
