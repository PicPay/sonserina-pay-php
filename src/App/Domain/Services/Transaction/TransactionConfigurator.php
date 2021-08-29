<?php

declare(strict_types=1);

namespace App\Domain\Services\Transaction;

use App\Domain\Contracts\TransactionProcessorInterface;
use App\Domain\Entities\Transaction;

class TransactionConfigurator implements TransactionProcessorInterface
{

    /**
     * @param Transaction $transaction
     * @param type $complement
     * @return void
     * @throws \Exception
     */
    public function process(Transaction $transaction, $complement = null): void
    {
        if (
                !is_array($complement) || (
                !(isset($complement['totalTax']) && is_float($complement['totalTax'])) ||
                !(isset($complement['sonserinaPay']) && is_float($complement['sonserinaPay'])) ||
                !(isset($complement['totalValueWithTax']) && is_float($complement['totalValueWithTax'])))
        ) {
            throw new \Exception('It was not possible to perform the configuration with the sent parameters');
        }

        $transaction->setCreatedDate(new \DateTime());
        $transaction->setTotalTax($complement['totalTax']);
        $transaction->setSlytherinPayTax($complement['sonserinaPay']);
        $transaction->setTotalAmount($complement['totalValueWithTax']);
    }

}
