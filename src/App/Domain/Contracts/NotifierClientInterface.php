<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Entities\Notification;

interface NotifierClientInterface
{
    public function notify(Notification $notifier): void;
}
