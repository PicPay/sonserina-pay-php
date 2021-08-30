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

    /**
     * @param Notifier $notifier
     */
    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * @param Transaction $transaction
     * @param type $complement
     * @return void
     */
    public function process(Transaction $transaction, $complement = null): void
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
