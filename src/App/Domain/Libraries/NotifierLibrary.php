<?php

declare(strict_types=1);

namespace App\Domain\Libraries;

use App\Domain\Contracts\NotifierClientInterface;
use App\Domain\Entities\Notification;

class NotifierLibrary implements NotifierClientInterface
{

    public function notify(Notification $notifier): void
    {
        
    }

}
