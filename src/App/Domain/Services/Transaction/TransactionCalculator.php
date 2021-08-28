<?php

declare(strict_types=1);

namespace App\Domain\Services\Transaction;

use App\Domain\Contracts\TransactionProcessorInterface;
use App\Domain\Services\TaxCalculator;
use App\Domain\Entities\Transaction;

class TransactionCalculator implements TransactionProcessorInterface
{

    /**
     * @var TaxCalculator
     */
    private TaxCalculator $taxCalculator;

    public function __construct(TaxCalculator $taxCalculator)
    {
        $this->taxCalculator = $taxCalculator;
    }

    public function process(Transaction $transaction, $complement = null): array
    {
        $sellerTax = $transaction->getSellerTax();

        $totalValueWithTax = $this->taxCalculator->calculate($transaction->getInitialAmount(), $sellerTax);

        $sonserinaPay = $transaction->getInitialAmount() + $sellerTax - $totalValueWithTax;
        $sonserinaPay = abs($sonserinaPay);

        $totalTax = $sellerTax + $sonserinaPay;

        return compact('sellerTax', 'totalValueWithTax', 'totalTax', 'sonserinaPay');
    }

}
