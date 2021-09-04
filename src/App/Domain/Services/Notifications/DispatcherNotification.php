<?php

declare(strict_types=1);

namespace App\Domain\Services\Notifications;

use App\Domain\Services\Notifier;
use App\Domain\Entities\Transaction;

class DispatcherNotification
{

    /**
     * @var Notifier
     */
    private Notifier $notifier;

    /**
     * @param Notifier $notifier
     */
    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * @param Transaction $transaction
     */
    public function sendNotify(Transaction $transaction)
    {
        $receptorsList = [
            $transaction->getBuyer(),
            $transaction->getSeller()
        ];

        foreach ($receptorsList as $receptor) {

            $notification = $this->notifier->getClient()->configure($receptor);

            $this->notifier->notify($notification);
        }
    }

}
