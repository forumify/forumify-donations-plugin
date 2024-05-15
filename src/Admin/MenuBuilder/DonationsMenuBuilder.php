<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\MenuBuilder;

use Forumify\Admin\MenuBuilder\AdminMenuBuilderInterface;
use Forumify\Core\MenuBuilder\Menu;
use Forumify\Core\MenuBuilder\MenuItem;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DonationsMenuBuilder implements AdminMenuBuilderInterface
{
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public function build(Menu $menu): void
    {
        $u = $this->urlGenerator->generate(...);

        $menu->addItem(new Menu('Donations', ['icon' => 'ph ph-currency-dollar'], [
            new MenuItem('Goals', $u('donations_admin_goals_list'), ['icon' => 'ph ph-target']),
            new MenuItem('Donations', $u('donations_admin_donations_list'), ['icon' => 'ph ph-currency-dollar'])
        ]));
    }
}
