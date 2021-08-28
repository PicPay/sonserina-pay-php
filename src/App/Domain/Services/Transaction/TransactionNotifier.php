<?php

declare(strict_types=1);

namespace App\Domain\Services\Transaction;

use App\Domain\Contracts\TransactionProcessorInterface;
use App\Domain\Services\Notifier;
use App\Domain\Entities\Transaction;

class TransactionNotifier implements TransactionProcessorInterface
{

    /**
     * @var Notifier
     */
    private Notifier $notifier;

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function process(Transaction $transaction, $complement = null): void
    {
        $notification = $this->notifier->getClient()->configure($transaction);

        $this->notifier->notify($notification);
    }

}
