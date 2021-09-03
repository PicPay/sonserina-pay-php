<?php

declare(strict_types=1);

namespace App\Domain\Services\Transactions;

use App\Domain\Entities\Transaction;

class TransactionSettings
{

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function setup(Transaction $transaction, array $taxValues = []): void
    {
        $transaction->setCreatedDate(new \DateTime());
        $transaction->setTotalAmount($taxValues['valueTotalWithTax']);
        $transaction->setSlytherinPayTax($taxValues['slytherinPayTax']);
        $transaction->setTotalTax($taxValues['totalTax']);
    }
}
