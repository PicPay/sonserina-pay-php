<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Contracts\TaxManagerClientInterface;

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
        return abs($initialAmount + $sellerTax - $totalValueWithTax);
    }

    /**
     * 
     * @param float $slytherinPayTax
     * @param float $sellerTax
     * @return float
     */
    public function calculateTotalTax(float $slytherinPayTax, float $sellerTax): float
    {
        return $slytherinPayTax + $sellerTax;
    }

}
