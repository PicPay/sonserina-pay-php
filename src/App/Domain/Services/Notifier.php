<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Clients\NotifierClientInterface;
use App\Domain\Entities\Notification;

class Notifier
{
    /**
     * @var NotifierClientInterface
     */
    private NotifierClientInterface $client;

    public function __construct(NotifierClientInterface $client)
    {
        $this->client = $client;
    }

    public function notify(Notification $notification): void
    {
        $this->client->notify($notification);
    }
}
