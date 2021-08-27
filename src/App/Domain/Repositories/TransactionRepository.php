<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Contracts\TransactionRepositoryInterface;
use App\Domain\Entities\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{

    public function save(Transaction $transaction): Transaction
    {
        //save another magic in database here ...

        return $transaction;
    }

}
