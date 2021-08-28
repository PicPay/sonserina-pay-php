<?php

declare(strict_types=1);

namespace App\Domain\Libraries;

use App\Domain\Contracts\NotifierClientInterface;
use App\Domain\Entities\Notification;
use App\Domain\Entities\Transaction;

class NotifierLibrary implements NotifierClientInterface
{

    private Notification $notifier;

    public function configure(Transaction $transaction): Notification
    {
        $this->notifier = new Notification();
        $this->notifier->setEmail($transaction->getBuyer()->getEmail());
        $this->notifier->setMessage('Transaction performed successfully');

        return $this->geNotifier();
    }

    public function geNotifier(): Notification
    {
        return $this->notifier;
    }

    public function notify(Notification $notification): void
    {
        echo 'Notifying ... [' . $notification->getEmail() . ']' . PHP_EOL;
    }

}
