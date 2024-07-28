<?php

declare(strict_types=1);

namespace Forumify\Donations;

use Forumify\Plugin\AbstractForumifyPlugin;
use Forumify\Plugin\PluginMetadata;

class ForumifyDonationsPlugin extends AbstractForumifyPlugin
{
    public function getPluginMetadata(): PluginMetadata
    {
        return new PluginMetadata(
            'Donations',
            'forumify',
            'Accept donations from your community members.',
            'https://forumify.net',
            'donations_admin_settings'
        );
    }

    public function getPermissions(): array
    {
        return [
            'admin' => [
                'view',
                'donations' => [
                    'view',
                    'manage',
                ],
                'donation_goals' => [
                    'view',
                    'manage',
                ],
            ],
        ];
    }
}
