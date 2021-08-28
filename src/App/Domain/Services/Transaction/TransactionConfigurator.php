<?php

declare(strict_types=1);

namespace App\Domain\Services\Transaction;

use App\Domain\Contracts\TransactionProcessorInterface;
use App\Domain\Entities\Transaction;

class TransactionConfigurator implements TransactionProcessorInterface
{

    public function process(Transaction $transaction, $complement = null): void
    {
        if (
                !is_array($complement) || (
                !isset($complement['totalTax']) ||
                !isset($complement['sonserinaPay']) ||
                !isset($complement['totalValueWithTax']))
        ) {
            throw new \Exception('It was not possible to perform the configuration with the sent parameters');
        }

        $transaction->setCreatedDate(new \DateTime());
        $transaction->setTotalTax($complement['totalTax']);
        $transaction->setSlytherinPayTax($complement['sonserinaPay']);
        $transaction->setTotalAmount($complement['totalValueWithTax']);
    }

}
