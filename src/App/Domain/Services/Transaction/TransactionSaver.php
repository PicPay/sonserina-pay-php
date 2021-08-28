<?php

declare(strict_types=1);

namespace App\Domain\Services\Transaction;

use App\Domain\Entities\Transaction;
use App\Domain\Contracts\TransactionRepositoryInterface;
use App\Domain\Contracts\TransactionProcessorInterface;

class TransactionSaver implements TransactionProcessorInterface
{

    /**
     * @var TransactionRepositoryInterface
     */
    private TransactionRepositoryInterface $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function process(Transaction $transaction, $complement = null): Transaction
    {
        return $this->repository->save($transaction);
    }

}
