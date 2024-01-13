<?php

declare(strict_types=1);

namespace App\Domain\Services\Notifications;

use App\Domain\Entities\Notification;

class GenerateNotification
{

    /**
     * @var Notification 
     */
    private Notification $notification;

    /**
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param Transaction $transaction
     */
    public function generate($notified): Notification
    {
        $this->notification->setEmail($notified->getEmail());
        $this->notification->setMessage('Transaction was successful !!');
        
        return $this->notification;
    }

}
