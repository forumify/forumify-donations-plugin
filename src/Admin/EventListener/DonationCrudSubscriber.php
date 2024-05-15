<?php

declare(strict_types=1);

namespace Forumify\Donations\Admin\EventListener;

use Forumify\Admin\Crud\Event\PreSaveCrudEvent;
use Forumify\Donations\Entity\Donation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DonationCrudSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            PreSaveCrudEvent::getName(Donation::class) => 'onDonationPreSave'
        ];
    }

    public function onDonationPreSave(PreSaveCrudEvent $event): void
    {
        $donation = $event->getEntity();
        if (!$donation instanceof Donation || !$event->isNew()) {
            return;
        }

        $donation->setPayload(['source' => 'Manual entry in admin panel']);
    }
}
