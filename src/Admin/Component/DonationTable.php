<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\Component;

use DateTime;
use Forumify\Core\Component\Table\AbstractDoctrineTable;
use Forumify\Core\Entity\User;
use Forumify\Donations\Entity\Donation;
use Forumify\Donations\Repository\DonationRepository;
use Forumify\Donations\Service\CurrencyFormatter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('Forumify\Donations\DonationTable', '@Forumify/components/table/table.html.twig')]
class DonationTable extends AbstractDoctrineTable
{
    public function __construct(
        DonationRepository $repository,
        private readonly CurrencyFormatter $currencyFormatter,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
        parent::__construct($repository);
        $this->sort = ['createdAt' => 'DESC'];
    }

    protected function buildTable(): void
    {
        $this
            ->addColumn('createdAt', [
                'label' => 'Donated At',
                'field' => 'createdAt',
                'renderer' => fn (DateTime $dt) => $dt->format('Y-m-d H:i:s'),
            ])
            ->addColumn('user', [
                'field' => 'user',
                'renderer' => fn (?User $user) => $user === null ? 'Anonymous' : $user->getUsername(),
            ])
            ->addColumn('goal', [
                'field' => 'goal?.title',
            ])
            ->addColumn('amount', [
                'field' => 'amount',
                'renderer' => fn (float $amount, Donation $donation) => $this->currencyFormatter->format($amount),
            ])
            ->addColumn('actions', [
                'label' => '',
                'field' => 'id',
                'searchable' => false,
                'sortable' => false,
                'renderer' => $this->renderActions(...),
            ]);
    }

    private function renderActions(int $id): string
    {
        $editUrl = $this->urlGenerator->generate('donations_admin_donations_edit', ['identifier' => $id]);
        $deleteUrl = $this->urlGenerator->generate('donations_admin_donations_delete', ['identifier' => $id]);

        return "
            <a class='btn-link btn-icon btn-small' href='$editUrl'><i class='ph ph-pencil-simple-line'></i></a>
            <a class='btn-link btn-icon btn-small' href='$deleteUrl'><i class='ph ph-x'></i></a>
        ";
    }
}
