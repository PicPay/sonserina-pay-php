<?php

declare(strict_types=1);

namespace App\Domain\Services\Notifications;

use App\Domain\Services\Notifier;
use App\Domain\Entities\Transaction;
use App\Domain\Services\Notifications\GenerateNotification;

class DispatcherNotification
{

    /**
     * @var Notifier
     */
    private Notifier $notifier;

    /**
     * @param Notifier $notifier
     */
    public function __construct(
        Notifier $notifier, 
        GenerateNotification $generateNotification
    ) {
        $this->notifier = $notifier;
        $this->generateNotification = $generateNotification;
    }

    /**
     * @param Transaction $transaction
     */
    public function sendNotify(Transaction $transaction)
    {
        $notified = [
            $transaction->getBuyer(),
            $transaction->getSeller()
        ];
       
        return array_map(function ($client) {
            $notification = $this->generateNotification->generate($client);
            $this->notifier->notify($notification);
        }, $notified);

    }

}
