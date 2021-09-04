<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Contracts\TaxManagerClientInterface;
use App\Domain\Entities\Transaction;

class TaxCalculator
{
    private const DEFAULT_INCREMENT_VALUE = 3.14;

    /**
     * @var TaxManagerClientInterface
     */
    private TaxManagerClientInterface $client;

    /**
     * TaxCalculator constructor.
     * @param TaxManagerClientInterface $client
     */
    public function __construct(TaxManagerClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param float $tax
     * @return float
     */
    private function getRealTaxValue(float $tax): float
    {
        $increment = self::DEFAULT_INCREMENT_VALUE;
        if ($tax > 5) {
            $increment = $this->client->getIncrementValue($tax);
        }
        return 1 + (($increment + $tax) / 100);
    }

    /**
     * @param Transaction $transaction
     * @return array
     */
    public function transactionTaxValues(Transaction $transaction): array
    {
        $verify = [
            $transaction->getInitialAmount(),
            $transaction->getSellerTax()
        ];

        foreach ($verify as $propretys) {
            if (empty($propretys)) {
                throw new \Exception('incorrect values for transaction');
            }
        }
        
        $initialAmount = $transaction->getInitialAmount();
        $sellerTax = $transaction->getSellerTax();

        $valueTotalWithTax = $this->calculate($initialAmount, $sellerTax);
        $slytherinPayTax = $this->calculateSlytherinPayTax($initialAmount, $sellerTax, $valueTotalWithTax);
        $totalTax = $this->calculateTotalTax($sellerTax, $slytherinPayTax);

        $transactionTaxValues = [
            'valueTotalWithTax' => $valueTotalWithTax,
            'slytherinPayTax' => $slytherinPayTax,
            'totalTax' => $totalTax,
        ];

        return $transactionTaxValues;
    }

    /**
     * @param float $amount
     * @param float $tax
     * @return float
     */
    public function calculate(float $amount, float $tax): float
    {
        return $amount * $this->getRealTaxValue($tax);
    }

    /**
     * @param float $initialAmount
     * @param float $sellerTax
     * @param float $totalValueWithTax
     * @return float
     */
    public function calculateSlytherinPayTax(float $initialAmount, float $sellerTax, float $totalValueWithTax): float
    {
        $slytherinPayTax = abs(($sellerTax + $initialAmount) - $totalValueWithTax);
        
        return $slytherinPayTax;
    }

    /**
     * 
     * @param float $sellerTax
     * @param float $slytherinPayTax
     * @return float
     */
    public function calculateTotalTax(float $sellerTax, float $slytherinPayTax): float
    {
        $totalTax = abs($sellerTax + $slytherinPayTax);

        return $totalTax;
    }
}
