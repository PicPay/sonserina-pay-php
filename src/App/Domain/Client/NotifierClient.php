<?php

declare(strict_types=1);

namespace App\Domain\Client;

use App\Domain\Contracts\NotifierClientInterface;
use App\Domain\Entities\Notification;

class NotifierClient implements NotifierClientInterface
{
    public function notify(Notification $notifier): void
    {
        echo nl2br("email= ".$notifier->getEmail()." message= ".$notifier->getMessage().PHP_EOL);
    }
}
