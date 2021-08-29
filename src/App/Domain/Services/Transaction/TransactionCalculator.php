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

    /**
     * @param TaxCalculator $taxCalculator
     */
    public function __construct(TaxCalculator $taxCalculator)
    {
        $this->taxCalculator = $taxCalculator;
    }

    /**
     * @param Transaction $transaction
     * @param type $complement
     * @return array
     */
    public function process(Transaction $transaction, $complement = null): array
    {
        $sellerTax = $transaction->getSellerTax();
        $initialAmount = $transaction->getInitialAmount();

        $totalValueWithTax = $this->taxCalculator->calculate($initialAmount, $sellerTax);

        $sonserinaPay = $initialAmount + $sellerTax - $totalValueWithTax;
        $sonserinaPay = abs($sonserinaPay);

        $totalTax = $sellerTax + $sonserinaPay;

        return compact('sellerTax', 'totalValueWithTax', 'totalTax', 'sonserinaPay');
    }

}
