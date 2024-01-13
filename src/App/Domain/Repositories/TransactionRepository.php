<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Contracts\TransactionRepositoryInterface;
use App\Domain\Entities\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function save(Transaction $transaction): Transaction
    {
        return $transaction;
    }

}
