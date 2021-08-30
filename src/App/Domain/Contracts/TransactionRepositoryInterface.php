<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Entities\Transaction;

interface TransactionRepositoryInterface
{

    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function save(Transaction $transaction): Transaction;
}
