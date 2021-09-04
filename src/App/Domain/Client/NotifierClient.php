<?php

declare(strict_types=1);

namespace App\Domain\Client;

use App\Domain\Contracts\NotifierClientInterface;
use App\Domain\Entities\Notification;

class NotifierClient implements NotifierClientInterface
{
    public function notify(Notification $notifier): void
    {
        $notification = [$notifier->getEmail(), $notifier->getMessage()];
        $notification = ['email' => $notifier->getEmail(), 'message' => $notifier->getMessage()];
        
        print_r('<br>__________[SEND NOTIFICATION]_________<br>');
        print_r($notification);
        print_r('<br>__________[SEND NOTIFICATION]_________<br>');
    }
}
