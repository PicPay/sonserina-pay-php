<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Entities\Transaction;

interface TransactionProcessorInterface
{

    /**
     * @param Transaction $transaction
     * @param type $complement
     */
    public function process(Transaction $transaction, $complement = null);
}
